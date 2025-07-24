<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

Route::middleware(['2fa','auth','verified'])->group(function () {
    Route::resource('/profile', App\Http\Controllers\Auth\ProfileController::class);
    Route::get('/search', [App\Http\Controllers\DashboardController::class, 'search']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/events', App\Http\Controllers\EventController::class);
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::resource('/sessions', App\Http\Controllers\SessionController::class);
});

require __DIR__.'/auth.php';
