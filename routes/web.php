<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Rain\Http\Livewire\Layouts;

Route::middleware(config('zeus-rain.middleware'))
    ->prefix(config('zeus-rain.path'))
    ->get('/{slug?}', Layouts::class)
    ->name('landing-page');
