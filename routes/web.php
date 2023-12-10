<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\DynamicDashboard\Livewire\Layouts;

Route::domain(config('zeus-dynamic-dashboard.domain'))
    ->middleware(config('zeus-dynamic-dashboard.middleware'))
    ->prefix(config('zeus-dynamic-dashboard.prefix'))
    ->get('/{slug?}', Layouts::class)
    ->name('landing-page');
