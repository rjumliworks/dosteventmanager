<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/verify', [App\Http\Controllers\Api\AuthController::class, 'verify']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

Route::get('/participant', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('sessions')->controller(App\Http\Controllers\Api\SessionController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/attendance', 'attendance');
    });

    Route::prefix('exhibitors')->controller(App\Http\Controllers\Api\ExhibitorController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/attendance', 'attendance');
        Route::post('/vote', 'vote');
    });
});