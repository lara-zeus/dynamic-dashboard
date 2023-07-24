<?php

namespace LaraZeus\Rain;

use LaraZeus\Core\CoreServiceProvider;
use LaraZeus\Rain\Commands\PublishCommand;
use LaraZeus\Rain\Commands\ZeusWidgetCommand;
use LaraZeus\Rain\Http\Livewire\Layouts;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RainServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-rain';

    public function packageBooted(): void
    {
        CoreServiceProvider::setThemePath('rain');
        Livewire::component('landing', Layouts::class);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasConfigFile()
            ->hasMigrations(['create_layouts_table'])
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
