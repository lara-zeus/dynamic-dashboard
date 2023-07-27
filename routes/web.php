<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Rain\Http\Livewire\Layouts;
use LaraZeus\Rain\RainPlugin;

Route::middleware(RainPlugin::get()->getMiddleware())
    ->prefix(RainPlugin::get()->getRainPrefix())
    ->get('/{slug?}', Layouts::class)
    ->name('landing-page');
