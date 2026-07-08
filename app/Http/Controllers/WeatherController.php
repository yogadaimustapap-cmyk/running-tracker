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
        $city = session('city', env('DEFAULT_CITY', 'Malang'));
        $weather = $this->weatherService->getWeatherData($city);

        return view('forecast', compact('weather'));
    }

    /**
     * Show the city settings form.
     */
    public function settings()
    {
        $city = session('city', env('DEFAULT_CITY', 'Malang'));
        return view('settings', compact('city'));
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
        session(['city' => $city]);

        return redirect()->route('dashboard')
            ->with('success_weather', "Kota pemantauan cuaca berhasil diperbarui ke {$city}!");
    }
}
