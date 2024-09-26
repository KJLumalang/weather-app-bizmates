<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather($city)
    {
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/forecast?q={$city},JP&appid={$apiKey}");

        if ($response->successful()) {
          
            $data = $response->json();

            
            $weatherData = [
                'city' => $data['city']['name'],
                'list' => array_map(function ($item) {
                    return [
                        'dt' => $item['dt'],
                        'temp' => $item['main']['temp'] - 273.15, // Convert Kelvin to Celsius
                        'humidity' => $item['main']['humidity'],
                        'weather' => $item['weather'][0]['description'],
                        'wind_speed' => $item['wind']['speed'],
                        'icon' => $item['weather'][0]['icon']
                    ];
                }, $data['list']),
            ];

            return response()->json($weatherData);
        } else {
            return response()->json(['error' => 'City not found'], 404);
        }
    }
}
