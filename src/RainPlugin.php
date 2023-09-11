<?php

namespace LaraZeus\Rain;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\Rain\Filament\Resources\LayoutResource;

final class RainPlugin implements Plugin
{
    use Configuration;
    use EvaluatesClosures;

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
        return new self();
    }

    public static function get(): static
    {
        // @phpstan-ignore-next-line
        return filament('zeus-rain');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
