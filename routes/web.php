<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/explore', function () {
    return view('explore');
})->name('explore');
