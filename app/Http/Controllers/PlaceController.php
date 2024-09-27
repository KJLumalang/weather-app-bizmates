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
        ]);

        return $response->json();
    }

}
