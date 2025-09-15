<?php

namespace App\Providers;

use App\Listeners\LoginFailed;
use App\Listeners\LoginSuccessful;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Schema::defaultStringLength(191);

        Event::listen(
            LoginSuccessful::class,
            LoginFailed::class
        );

        \Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            if($value != null){
                $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
                if (in_array($type, $parameters)) {
                    return true;
                }
                return false;
            }
        });
    }
}
