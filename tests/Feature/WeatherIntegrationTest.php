<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeatherIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guests are redirected to login for weather endpoints.
     */
    public function test_guests_cannot_access_weather_features(): void
    {
        $this->get('/forecast')->assertRedirect('/login');
        $this->get('/weather-settings')->assertRedirect('/login');
        $this->post('/weather-settings', ['city' => 'Surabaya'])->assertRedirect('/login');
    }

    /**
     * Test weather calculations on dashboard.
     */
    public function test_dashboard_shows_weather_details(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Malang');
        $response->assertSee('Kelembapan');
        $response->assertSee('Angin');
        $response->assertSee('Jam Terbaik Lari');
    }

    /**
     * Test forecast page loads.
     */
    public function test_forecast_page_renders_successfully(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/forecast');

        $response->assertStatus(200);
        $response->assertSee('Prakiraan Cuaca per Jam');
        $response->assertSee('Malang');
    }

    /**
     * Test settings page rendering and city update.
     */
    public function test_user_can_update_weather_city_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/weather-settings');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Pemantauan Cuaca');

        $updateResponse = $this->actingAs($user)->post('/weather-settings', [
            'city' => 'Jakarta',
        ]);

        $updateResponse->assertRedirect('/dashboard');
        $updateResponse->assertSessionHas('success_weather');
        
        $this->assertEquals('Jakarta', session('city'));

        // Dashboard should now show Jakarta weather
        $dashboardResponse = $this->actingAs($user)->get('/dashboard');
        $dashboardResponse->assertSee('📍 Jakarta');
    }

    /**
     * Test user cannot update city to an invalid city that OpenWeatherMap does not recognize.
     */
    public function test_user_cannot_update_invalid_weather_city(): void
    {
        $user = User::factory()->create();

        $mockService = $this->createMock(WeatherService::class);
        $mockService->method('isValidCity')->with('dhuijs')->willReturn(false);

        $this->app->instance(WeatherService::class, $mockService);

        $response = $this->actingAs($user)->post('/weather-settings', [
            'city' => 'dhuijs',
        ]);

        $response->assertSessionHasErrors(['city']);
        $this->assertNull(session('city'));
    }

    /**
     * Test user can reset manual city selection to fall back to Geolocation detection.
     */
    public function test_user_can_reset_manual_weather_city(): void
    {
        $user = User::factory()->create();

        session(['city' => 'Jakarta']);

        $response = $this->actingAs($user)->get('/weather-settings/reset');
        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success_weather');

        $this->assertNull(session('city'));
        $this->assertNull(session('lat'));
        $this->assertNull(session('lon'));
    }

    /**
     * Test the WeatherService safety logic directly.
     */
    public function test_weather_service_safety_evaluations(): void
    {
        $service = new WeatherService();

        // 1. Ideal conditions
        $safeData = $service->getMockWeatherData('Malang');
        
        // Let's directly call the protected/public helper methods to verify safety logic
        // Clear, Temp 24C, Wind 8.5 km/h, Humidity 62%
        // Using reflection or testing logic indirectly via mocks
        $mockSafe = $this->invokePrivateMethod($service, 'evaluateSafety', [
            false, // isRaining
            25.0,  // temp
            10.0,  // windSpeed (km/h)
            60     // humidity
        ]);
        $this->assertTrue($mockSafe);

        // 2. Raining
        $rainyMock = $this->invokePrivateMethod($service, 'evaluateSafety', [
            true, // isRaining
            25.0,
            10.0,
            60
        ]);
        $this->assertFalse($rainyMock);

        // 3. Hot temperature (32C)
        $hotMock = $this->invokePrivateMethod($service, 'evaluateSafety', [
            false,
            32.0,
            10.0,
            60
        ]);
        $this->assertFalse($hotMock);

        // 4. Cold temperature (15C)
        $coldMock = $this->invokePrivateMethod($service, 'evaluateSafety', [
            false,
            15.0,
            10.0,
            60
        ]);
        $this->assertFalse($coldMock);

        // 5. Strong wind (25 km/h)
        $windMock = $this->invokePrivateMethod($service, 'evaluateSafety', [
            false,
            25.0,
            25.0,
            60
        ]);
        $this->assertFalse($windMock);

        // 6. High humidity (85%)
        $humidityMock = $this->invokePrivateMethod($service, 'evaluateSafety', [
            false,
            25.0,
            10.0,
            85
        ]);
        $this->assertFalse($humidityMock);
    }

    /**
     * Test guests are blocked from updating location.
     */
    public function test_guests_cannot_update_location_coordinates(): void
    {
        $this->get('/update-location?lat=-7.98&lon=112.63')->assertRedirect('/login');
    }

    /**
     * Test authenticated user can update coordinate session parameters and dashboard reflects it.
     */
    public function test_user_can_update_location_coordinates(): void
    {
        $user = User::factory()->create();

        // 1. Trigger update location coordinate request
        $response = $this->actingAs($user)->get('/update-location?lat=-6.20&lon=106.84');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals(-6.20, (float) session('lat'));
        $this->assertEquals(106.84, (float) session('lon'));
        $this->assertNull(session('city'));

        // 2. View dashboard and verify it shows resolved city (Jakarta)
        $dashboardResponse = $this->actingAs($user)->get('/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('📍 Jakarta');
    }

    /**
     * Helper to test protected method evaluations.
     */
    protected function invokePrivateMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}
