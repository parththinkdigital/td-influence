<?php

use Illuminate\Foundation\DevCommands;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('social:sync-metrics')->twiceDaily(1, 13)->withoutOverlapping();

// Bind development server to 0.0.0.0:8000 so devices on the local network (e.g. 192.168.1.27) can access it
if (class_exists(DevCommands::class)) {
    DevCommands::artisan('serve --host=0.0.0.0 --port=8000', 'server');
}
