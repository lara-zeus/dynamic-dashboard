<?php

namespace LaraZeus\Rain;

use Filament\Contracts\Plugin;
use Filament\Panel;
use LaraZeus\Rain\Filament\Resources\LayoutResource;

class RainPlugin implements Plugin
{
    use Configuration;

    public function getId(): string
    {
        return 'zeus-rain';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                LayoutResource::class,
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): Plugin | \Filament\FilamentManager
    {
        return filament(app(static::class)->getId());
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
