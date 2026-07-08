<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthWorkflowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guest is redirected from / to /login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test that user can register and is redirected to dashboard.
     */
    public function test_user_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => 'on',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name' => 'Test User',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test validation rules on registration.
     */
    public function test_registration_validation_fails(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }

    /**
     * Test that user can login and is redirected to dashboard.
     */
    public function test_user_can_login_successfully(): void
    {
        $user = User::factory()->create([
            'email' => 'loginuser@example.com',
            'password' => bcrypt('secret-password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'loginuser@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test validation/credentials failure on login.
     */
    public function test_login_fails_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'loginuser@example.com',
            'password' => bcrypt('secret-password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'loginuser@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test that user can logout.
     */
    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test that guest cannot access dashboard.
     */
    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
