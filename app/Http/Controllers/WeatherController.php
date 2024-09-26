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

        return $response->json();
    }
}
