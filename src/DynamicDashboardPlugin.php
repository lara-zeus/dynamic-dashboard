<?php

namespace LaraZeus\DynamicDashboard;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;
use LaraZeus\FilamentPluginTools\Concerns\CanHideResources;
use LaraZeus\FilamentPluginTools\Concerns\HasEnums;
use LaraZeus\FilamentPluginTools\Concerns\HasModels;
use LaraZeus\FilamentPluginTools\Concerns\HasNavigationGroupLabel;
use LaraZeus\FilamentPluginTools\Concerns\HasResources;
use LaraZeus\FilamentPluginTools\Concerns\HasUploads;

final class DynamicDashboardPlugin implements Plugin
{
    use CanHideResources;
    use Configuration;
    use EvaluatesClosures;
    use HasEnums;
    use HasModels;
    use HasNavigationGroupLabel;
    use HasResources;
    use HasUploads;

    protected Closure | string $navigationGroupLabel = 'Dynamic Dashboard';

    public function getId(): string
    {
        return 'zeus-dynamic-dashboard';
    }

    public function register(Panel $panel): void
    {
        $layoutResource = $this->resolveResource('Layout') ?? LayoutResource::class;

        if (! in_array($layoutResource, $this->getHiddenResources(), true)) {
            $panel->resources([
                $layoutResource,
            ]);
        }
    }

    public static function make(): static
    {
        return new self;
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
