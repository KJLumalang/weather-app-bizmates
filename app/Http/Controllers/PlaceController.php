<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlaceController extends Controller
{
    public function getPlaces($city)
    {
        $apiKey = env('FOURSQUARE_API_KEY');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $apiKey,
        ])->get("https://api.foursquare.com/v3/places/search", [
            'near' => "{$city},JP",
            'limit' => 10,
        ]);

        return $response->json();
    }

    public function getChains($city)
    {
        $apiKey = env('FOURSQUARE_API_KEY');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => $apiKey,
        ])->get("https://api.foursquare.com/v3/events/search", [
            'near' => "{$city},JP",
            'limit' => 10,
            'chain' => true,
        ]);

        return $response->json();
    }

}
