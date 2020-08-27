<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('game')->name('game.')->group(function () {
    Route::get('/', 'GameController@startGame')->name('start');
    Route::post('/', 'GameController@answer')->name('answer');
    Route::post('/newdish', 'GameController@newDish')->name('new-dish');
    // Route::get('/{id}', 'GameController@show')->name('show');
    // Route::get('/{id}/stats', 'GameController@stats')->name('stats');
    // Route::post('/', 'GameController@store')->name('store');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
