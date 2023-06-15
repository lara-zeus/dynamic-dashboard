<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Rain\Http\Livewire\Widgets;

Route::middleware(config('zeus-rain.middleware'))
    ->prefix(config('zeus-rain.path'))
    ->get('/', Widgets::class)
    ->name('contact');
