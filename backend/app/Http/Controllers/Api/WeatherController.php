<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    /**
     * Get weather information from OpenWeatherMap API for a specific city.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getWeather(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $apiKey = config('services.openweathermap.key');
        $city = $request->city;

        try {
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                return response()->json([
                    'is_success' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'is_success' => false,
                    'message' => 'Failed to retrieve weather data',
                    'error' => $response->json(),
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'An error occurred while fetching weather data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get weather information from OpenWeatherMap API for a specific city via route parameter.
     *
     * @param string $city
     * @return JsonResponse
     */
    public function getWeatherByCity(string $city): JsonResponse
    {
        $validator = Validator::make(['city' => $city], [
            'city' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $apiKey = config('services.openweathermap.key');

        try {
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                return response()->json([
                    'is_success' => true,
                    'data' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'is_success' => false,
                    'message' => 'Failed to retrieve weather data',
                    'error' => $response->json(),
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'An error occurred while fetching weather data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
