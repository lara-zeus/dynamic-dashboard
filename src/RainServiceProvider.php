<?php

namespace LaraZeus\Rain;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use LaraZeus\Rain\Console\PublishCommand;
use LaraZeus\Rain\Filament\Resources\LayoutResource;
use LaraZeus\Rain\Http\Livewire\Widgets;
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
        Livewire::component('landing', Widgets::class);

        View::share('', 'rain-theme::themes.' . config('zeus-rain.theme', 'zeus'));

        App::singleton('rain-theme', function () {
            return 'zeus-rain::themes.' . config('zeus-rain.theme', 'zeus');
        });
    }

    protected function getCommands(): array
    {
        return [
            PublishCommand::class,
        ];
    }

    public function packageConfiguring(Package $package): void
    {
        $package
            ->hasMigrations(['create_widgets_table'])
            ->hasRoute('web');
    }
}
