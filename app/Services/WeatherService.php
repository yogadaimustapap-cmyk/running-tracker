<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $apiKey;
    protected $defaultCity;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHER_API_KEY');
        $this->defaultCity = env('DEFAULT_CITY', 'Malang');
    }

    /**
     * Get weather data (current + forecast + recommendation) for a city.
     */
    public function getWeatherData(string $city = null, float $lat = null, float $lon = null): array
    {
        $city = $city ?: $this->defaultCity;

        if (empty($this->apiKey)) {
            return $this->getMockWeatherData($city, $lat, $lon);
        }

        try {
            $currentUrl = "https://api.openweathermap.org/data/2.5/weather";
            $forecastUrl = "https://api.openweathermap.org/data/2.5/forecast";

            $queryParams = [
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'id',
            ];

            if ($lat !== null && $lon !== null) {
                $queryParams['lat'] = $lat;
                $queryParams['lon'] = $lon;
            } else {
                $queryParams['q'] = $city;
            }

            // Fetch Current Weather
            $currentResponse = Http::get($currentUrl, $queryParams);

            // Fetch Forecast (5 days/3 hours)
            $forecastResponse = Http::get($forecastUrl, $queryParams);

            if ($currentResponse->successful() && $forecastResponse->successful()) {
                $currentData = $currentResponse->json();
                $forecastData = $forecastResponse->json();
                
                // Dynamically resolve city name from coordinates response if queried by coords
                $resolvedCity = $currentData['name'] ?? $city;

                return $this->parseApiResponse($resolvedCity, $currentData, $forecastData);
            }

            Log::warning("OpenWeatherMap API request failed, falling back to mock data.");
            return $this->getMockWeatherData($city, $lat, $lon);

        } catch (\Exception $e) {
            Log::error("Error fetching weather data from OpenWeatherMap: " . $e->getMessage());
            return $this->getMockWeatherData($city, $lat, $lon);
        }
    }

    /**
     * Parse raw API responses into application format.
     */
    protected function parseApiResponse(string $city, array $current, array $forecast): array
    {
        $temp = $current['main']['temp'];
        $humidity = $current['main']['humidity'];
        $windSpeed = $current['wind']['speed'] * 3.6; // convert m/s to km/h
        $conditionId = $current['weather'][0]['id'] ?? 800;
        $conditionName = $this->mapConditionIdToName($conditionId);
        $description = ucfirst($current['weather'][0]['description'] ?? '');

        // Determine if it is raining
        $isRaining = ($conditionId >= 200 && $conditionId < 600); // 2xx (Thunderstorm), 3xx (Drizzle), 5xx (Rain)

        // Evaluate safety logic
        $isSafe = $this->evaluateSafety($isRaining, $temp, $windSpeed, $humidity);

        // Format hourly forecast (take next 6 intervals, which is 18 hours ahead)
        $hourlyList = [];
        $limit = min(6, count($forecast['list'] ?? []));
        for ($i = 0; $i < $limit; $i++) {
            $item = $forecast['list'][$i];
            $itemTime = date('H.i', $item['dt']);
            $itemTemp = round($item['main']['temp']);
            $itemCondId = $item['weather'][0]['id'] ?? 800;
            $itemCondName = $this->mapConditionIdToName($itemCondId);
            $itemIcon = $this->getConditionIcon($itemCondId);

            $hourlyList[] = [
                'time' => $itemTime,
                'temp' => $itemTemp,
                'condition' => $itemCondName,
                'icon' => $itemIcon,
            ];
        }

        // Running hours recommendation
        $recommendations = $this->getRecommendedHours($hourlyList);

        return [
            'city' => ucfirst($city),
            'temp' => round($temp),
            'condition' => $conditionName,
            'description' => $description,
            'humidity' => $humidity,
            'wind' => round($windSpeed, 1),
            'icon' => $this->getConditionIcon($conditionId),
            'is_safe' => $isSafe,
            'reasons' => $this->getUnsafeReasons($isRaining, $temp, $windSpeed, $humidity),
            'best_hours' => $recommendations,
            'forecast' => $hourlyList,
        ];
    }

    /**
     * Evaluate running safety conditions.
     */
    protected function evaluateSafety(bool $isRaining, float $temp, float $windSpeed, int $humidity): bool
    {
        return !$isRaining &&
               ($temp >= 18 && $temp <= 30) &&
               ($windSpeed < 20) &&
               ($humidity < 80);
    }

    /**
     * Get reasons why conditions are unsafe for running.
     */
    protected function getUnsafeReasons(bool $isRaining, float $temp, float $windSpeed, int $humidity): array
    {
        $reasons = [];
        if ($isRaining) {
            $reasons[] = 'Hujan sedang turun';
        }
        if ($temp < 18) {
            $reasons[] = 'Suhu terlalu dingin (< 18°C)';
        }
        if ($temp > 30) {
            $reasons[] = 'Suhu terlalu panas (> 30°C)';
        }
        if ($windSpeed >= 20) {
            $reasons[] = 'Angin terlalu kencang (≥ 20 km/jam)';
        }
        if ($humidity >= 80) {
            $reasons[] = 'Kelembapan terlalu tinggi (≥ 80%)';
        }
        return $reasons;
    }

    /**
     * Map Weather Condition IDs to Custom UI names.
     */
    protected function mapConditionIdToName(int $id): string
    {
        if ($id >= 200 && $id < 300) return 'Badai';
        if ($id >= 300 && $id < 400) return 'Gerimis';
        if ($id >= 500 && $id < 600) return 'Hujan';
        if ($id >= 600 && $id < 700) return 'Bersalju';
        if ($id >= 700 && $id < 800) return 'Berkabut';
        if ($id == 800) return 'Cerah';
        if ($id > 800 && $id <= 802) return 'Cerah Berawan';
        return 'Berawan';
    }

    /**
     * Get SVG Icons or emojis representing conditions.
     */
    protected function getConditionIcon(int $id): string
    {
        if ($id >= 200 && $id < 300) return '⚡'; // Badai
        if ($id >= 300 && $id < 400) return '🌦️'; // Gerimis
        if ($id >= 500 && $id < 600) return '🌧️'; // Hujan
        if ($id >= 600 && $id < 700) return '❄️'; // Bersalju
        if ($id >= 700 && $id < 800) return '🌫️'; // Kabut
        if ($id == 800) return '☀️'; // Cerah
        if ($id > 800 && $id <= 802) return '🌤️'; // Cerah berawan
        return '☁️'; // Berawan tebal
    }

    /**
     * Get recommended running hours.
     */
    protected function getRecommendedHours(array $hourlyForecast): array
    {
        // Default standard hours
        $morning = '06.00–07.30';
        $afternoon = '16.30–18.00';

        // Check if forecast indicates bad weather during those times
        // E.g., if forecast for 06.00, 07.00, or 08.00 has 'Hujan' / 'Badai', morning is not recommended.
        $morningRain = false;
        $afternoonRain = false;

        foreach ($hourlyForecast as $forecast) {
            $hour = (int) explode('.', $forecast['time'])[0];
            $cond = $forecast['condition'];
            $isWet = ($cond === 'Hujan' || $cond === 'Badai' || $cond === 'Gerimis');

            if ($isWet) {
                if ($hour >= 5 && $hour <= 9) {
                    $morningRain = true;
                }
                if ($hour >= 15 && $hour <= 19) {
                    $afternoonRain = true;
                }
            }
        }

        $times = [];
        if (!$morningRain) {
            $times[] = [
                'time' => $morning,
                'label' => 'Pagi Hari (Terbaik)',
            ];
        } else {
            $times[] = [
                'time' => $morning,
                'label' => 'Pagi Hari (Tidak disarankan: Diprediksi Hujan)',
                'warning' => true,
            ];
        }

        if (!$afternoonRain) {
            $times[] = [
                'time' => $afternoon,
                'label' => 'Sore Hari',
            ];
        } else {
            $times[] = [
                'time' => $afternoon,
                'label' => 'Sore Hari (Tidak disarankan: Diprediksi Hujan)',
                'warning' => true,
            ];
        }

        return $times;
    }

    /**
     * Generate realistic mock data for local fallback.
     */
    public function getMockWeatherData(string $city, float $lat = null, float $lon = null): array
    {
        $resolvedCity = $city;
        if ($lat !== null && $lon !== null) {
            // Map coordinates to deterministic simulated cities for mock consistency
            if (abs($lat - (-7.98)) < 0.5 && abs($lon - 112.63) < 0.5) {
                $resolvedCity = 'Malang';
            } elseif (abs($lat - (-6.20)) < 0.5 && abs($lon - 106.84) < 0.5) {
                $resolvedCity = 'Jakarta';
            } else {
                $resolvedCity = 'Lokasi Anda';
            }
        }

        // Seed based on city name string to keep mock consistent per city
        $cityHash = crc32(strtolower($resolvedCity));
        
        // Determinstic mock data
        $temps = [24, 25, 27, 28, 31, 22];
        $temp = $temps[abs($cityHash) % count($temps)];
        
        $humidities = [62, 65, 75, 82, 55];
        $humidity = $humidities[abs($cityHash + 1) % count($humidities)];
        
        $windSpeeds = [8.5, 9.2, 12.0, 15.5, 21.0];
        $windSpeed = $windSpeeds[abs($cityHash + 2) % count($windSpeeds)];
        
        $conditions = ['Cerah', 'Cerah Berawan', 'Berawan', 'Gerimis', 'Hujan'];
        $condition = $conditions[abs($cityHash + 3) % count($conditions)];

        $isRaining = ($condition === 'Hujan' || $condition === 'Gerimis');
        $isSafe = $this->evaluateSafety($isRaining, $temp, $windSpeed, $humidity);

        // Map mock condition to icon
        $icon = '☀️';
        if ($condition === 'Cerah Berawan') $icon = '🌤️';
        if ($condition === 'Berawan') $icon = '☁️';
        if ($condition === 'Gerimis') $icon = '🌦️';
        if ($condition === 'Hujan') $icon = '🌧️';

        // Forecast hours generator
        $hourlyList = [];
        $startHour = (int) date('H');
        for ($i = 0; $i < 6; $i++) {
            $hour = ($startHour + ($i * 2)) % 24;
            $timeStr = sprintf("%02d.00", $hour);
            
            // Forecast fluctuates slightly
            $fcTemp = $temp + ($i % 2 === 0 ? 1 : -1) * ($i % 3);
            $fcCond = $conditions[abs($cityHash + $i) % count($conditions)];
            
            $fcIcon = '☀️';
            if ($fcCond === 'Cerah Berawan') $fcIcon = '🌤️';
            if ($fcCond === 'Berawan') $fcIcon = '☁️';
            if ($fcCond === 'Gerimis') $fcIcon = '🌦️';
            if ($fcCond === 'Hujan') $fcIcon = '🌧️';

            $hourlyList[] = [
                'time' => $timeStr,
                'temp' => round($fcTemp),
                'condition' => $fcCond,
                'icon' => $fcIcon,
            ];
        }

        $recommendations = $this->getRecommendedHours($hourlyList);

        return [
            'city' => ucfirst($city),
            'temp' => round($temp),
            'condition' => $condition,
            'description' => $condition . ' di wilayah ' . ucfirst($city),
            'humidity' => $humidity,
            'wind' => round($windSpeed, 1),
            'icon' => $icon,
            'is_safe' => $isSafe,
            'reasons' => $this->getUnsafeReasons($isRaining, $temp, $windSpeed, $humidity),
            'best_hours' => $recommendations,
            'forecast' => $hourlyList,
        ];
    }

    /**
     * Check if a city is valid by querying OpenWeatherMap.
     */
    public function isValidCity(string $city): bool
    {
        if (empty($this->apiKey)) {
            // Allow random testing if API key is not configured locally
            return true;
        }

        try {
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $this->apiKey,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            // Graceful fallback to true on network issues
            return true;
        }
    }
}
