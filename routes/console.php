<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command('notify:due-tsrs')->weekdays()->dailyAt('08:00');
Schedule::command('notify:schedule')->weekdays()->dailyAt('08:00');
// Schedule::command('notify:due-tsrs')->weekdays()->dailyAt('12:00');