<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/verify', [App\Http\Controllers\Api\AuthController::class, 'verify']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
