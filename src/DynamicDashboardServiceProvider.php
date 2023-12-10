<?php

namespace LaraZeus\DynamicDashboard;

use LaraZeus\Core\CoreServiceProvider;
use LaraZeus\DynamicDashboard\Commands\PublishCommand;
use LaraZeus\DynamicDashboard\Commands\ZeusWidgetCommand;
use LaraZeus\DynamicDashboard\Livewire\Layouts;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DynamicDashboardServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-dynamic-dashboard';

    public function packageBooted(): void
    {
        CoreServiceProvider::setThemePath('dynamic-dashboard');
        Livewire::component('landing', Layouts::class);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasConfigFile()
            ->hasCommands(static::getCommands())
            ->hasMigrations([
                'create_layouts_table',
                'add_is_active_to_layouts_table',
            ])
            ->hasViews('zeus')
            ->hasRoute('web');
    }

    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
            ZeusWidgetCommand::class,
        ];
    }
}
