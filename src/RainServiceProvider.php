<?php

namespace LaraZeus\Rain;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use LaraZeus\Rain\Commands\PublishCommand;
use LaraZeus\Rain\Commands\ZeusFieldCommand;
use LaraZeus\Rain\Filament\Resources\LayoutResource;
use LaraZeus\Rain\Http\Livewire\Layouts;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class RainServiceProvider extends PluginServiceProvider
{
    public static string $name = 'zeus-rain';

    protected array $resources = [
        LayoutResource::class,
    ];

    public function bootingPackage(): void
    {
        Livewire::component('landing', Layouts::class);

        View::share('rain-theme', 'rain-theme::themes.'.config('zeus-rain.theme', 'zeus'));

        App::singleton('rain-theme', function () {
            return 'zeus-rain::themes.'.config('zeus-rain.theme', 'zeus');
        });
    }

    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
            ZeusFieldCommand::class,
        ];
    }

    public function packageConfiguring(Package $package): void
    {
        $package
            ->hasMigrations(['create_layouts_table'])
            ->hasRoute('web');
    }
}
