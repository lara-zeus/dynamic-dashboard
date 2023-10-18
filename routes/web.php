<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Rain\Livewire\Layouts;

Route::domain(config('zeus-rain.domain'))
    ->middleware(config('zeus-rain.middleware'))
    ->prefix(config('zeus-rain.prefix'))
    ->get('/{slug?}', Layouts::class)
    ->name('landing-page');
