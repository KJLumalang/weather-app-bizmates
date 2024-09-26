<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PlaceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/weather/{city}', [WeatherController::class, 'getWeather']);
Route::get('/places/{city}', [PlaceController::class, 'getPlaces']);
