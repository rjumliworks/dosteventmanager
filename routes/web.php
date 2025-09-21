<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);
Route::get('/privacy-policy', [App\Http\Controllers\WelcomeController::class, 'policy']);
Route::post('/mail', [App\Http\Controllers\OtpController::class, 'mail']);
Route::post('/verify', [App\Http\Controllers\OtpController::class, 'verify']);
Route::post('/', [App\Http\Controllers\RegistrationController::class, 'store']);
Route::get('/captcha', function () {
    return response()->json([
        'src' => captcha_src('flat') // always flat style
    ]);
});

Route::get('/participant/login', [App\Http\Controllers\ParticipantController::class, 'login'])->name('participant.login');
Route::middleware('auth:participant')->group(function () {
    Route::get('/participant', [App\Http\Controllers\ParticipantController::class, 'view'])->name('participant.dashboard');
    Route::get('/participant/logout', [App\Http\Controllers\ParticipantController::class, 'logout'])->name('participant.logout');
    Route::get('/qrcode', [App\Http\Controllers\Participant\IndexController::class, 'qrcode']);
    Route::get('/settings', [App\Http\Controllers\Participant\IndexController::class, 'settings']);
    Route::get('/exhibits', [App\Http\Controllers\Participant\IndexController::class, 'sessions']);
    
    Route::get('/schedules', [App\Http\Controllers\Participant\IndexController::class, 'schedules']);
    Route::get('/schedule/{id}', [App\Http\Controllers\Participant\IndexController::class, 'scheduleview']);
});

Route::middleware(['2fa','auth','verified'])->group(function () {
    Route::resource('/profile', App\Http\Controllers\Auth\ProfileController::class);
    Route::get('/search', [App\Http\Controllers\DashboardController::class, 'search']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/events', App\Http\Controllers\EventController::class);
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::resource('/participants', App\Http\Controllers\ParticipantController::class);
    Route::post('/import', [App\Http\Controllers\ParticipantController::class, 'import']);
    Route::resource('/sessions', App\Http\Controllers\SessionController::class);
    Route::resource('/exhibitors', App\Http\Controllers\ExhibitorController::class);
    Route::resource('/hotels', App\Http\Controllers\HotelController::class);

    Route::get('/print', [App\Http\Controllers\PrintController::class, 'index']);
});

Route::get('/event/{key}', [App\Http\Controllers\EventController::class, 'view']);
Route::get('/session/{key}', [App\Http\Controllers\SessionController::class, 'view']);
// Route::get('/hotels', [App\Http\Controllers\WelcomeController::class, 'hotel_index']);
Route::get('/highlights', [App\Http\Controllers\WelcomeController::class, 'highlight_index']);
Route::get('/registration', [App\Http\Controllers\WelcomeController::class, 'registration_index']);

require __DIR__.'/auth.php';
