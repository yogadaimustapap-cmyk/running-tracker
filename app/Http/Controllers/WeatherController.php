<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Show the hourly weather forecast.
     */
    public function forecast()
    {
        $city = session('city');
        $lat = session('lat');
        $lon = session('lon');

        if ($city) {
            $weather = $this->weatherService->getWeatherData($city);
        } elseif ($lat !== null && $lon !== null) {
            $weather = $this->weatherService->getWeatherData(null, $lat, $lon);
        } else {
            $weather = $this->weatherService->getWeatherData(env('DEFAULT_CITY', 'Malang'));
        }

        return view('forecast', compact('weather'));
    }

    /**
     * Show the city settings form.
     */
    public function settings()
    {
        $city = session('city');
        $isAuto = !$city;
        $displayCity = $city ?: (session('lat') && session('lon') ? 'Lokasi Otomatis' : env('DEFAULT_CITY', 'Malang'));

        return view('settings', [
            'city' => $displayCity,
            'isAuto' => $isAuto,
        ]);
    }

    /**
     * Update the active city in session.
     */
    public function updateCity(Request $request)
    {
        $request->validate([
            'city' => ['required', 'string', 'max:255'],
        ]);

        $city = trim($request->city);

        if (!$this->weatherService->isValidCity($city)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['city' => "Kota '{$city}' tidak ditemukan. Silakan masukkan nama kota yang valid."]);
        }

        session(['city' => $city]);
        session()->forget(['lat', 'lon']);

        return redirect()->route('dashboard')
            ->with('success_weather', "Kota pemantauan cuaca berhasil diperbarui ke {$city}!");
    }

    /**
     * Reset manual city override and enable Geolocation.
     */
    public function resetLocation()
    {
        session()->forget(['city', 'lat', 'lon']);

        return redirect()->route('dashboard')
            ->with('success_weather', "Pengaturan lokasi telah direset. Sistem akan menggunakan deteksi otomatis lokasi saat ini!");
    }

    /**
     * Update coordinate session variables from Geolocation browser prompt.
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'lat' => ['required', 'numeric'],
            'lon' => ['required', 'numeric'],
        ]);

        session([
            'lat' => (float) $request->lat,
            'lon' => (float) $request->lon,
        ]);

        // Forget city override so coordinates take priority
        session()->forget('city');

        return response()->json(['success' => true]);
    }
}
