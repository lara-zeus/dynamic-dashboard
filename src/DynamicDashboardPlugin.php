<?php

namespace LaraZeus\DynamicDashboard;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;

final class DynamicDashboardPlugin implements Plugin
{
    use Configuration;
    use EvaluatesClosures;

    public function getId(): string
    {
        return 'zeus-dynamic-dashboard';
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
        return filament('zeus-dynamic-dashboard');
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
