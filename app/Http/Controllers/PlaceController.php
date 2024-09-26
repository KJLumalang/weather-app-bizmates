<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlaceController extends Controller
{
    public function getPlaces($city)
    {
        $apiKey = env('FOURSQUARE_API_KEY');
        $response = Http::get("https://api.foursquare.com/v2/venues/search", [
            'near' => "{$city},JP",
            'limit' => 5,
            'client_id' => env('FOURSQUARE_CLIENT_ID'),
            'client_secret' => env('FOURSQUARE_CLIENT_SECRET'),
            'v' => '20210901'
        ]);

        return $response->json();
    }
}
