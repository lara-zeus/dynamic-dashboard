<?php

namespace LaraZeus\Rain\Facades;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Finder\Finder;

class Rain extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'rain';
    }

    public static function loadClasses(string $path, string $namespace): array
    {
        $classes = [];
        $path = array_unique(Arr::wrap($path));

        foreach ((new Finder())->in($path)->files() as $className) {
            $classes[] = $namespace . $className->getFilenameWithoutExtension();
        }

        return $classes;
    }

    public static function available(): array
    {
        $coreWidgets = self::collectWidgets(__DIR__ . '/../Widgets/Classes', 'LaraZeus\\Rain\\Widgets\\Classes\\');
        $appWidgets = self::collectWidgets(app_path('Zeus/Widgets'), 'App\\Zeus\\Widgets\\');

        $widgets = collect();

        if (! $coreWidgets->isEmpty()) {
            $widgets = $widgets->merge($coreWidgets);
        }

        if (! $appWidgets->isEmpty()) {
            $widgets = $widgets->merge($appWidgets);
        }

        return $widgets->sortBy('sort')->toArray();
    }

    public static function collectWidgets(string $path, string $namespace): Collection
    {
        if (! is_dir($path)) {
            return collect();
        }

        $classes = self::loadClasses($path, $namespace);
        $allWidgets = self::setLayout($classes);

        return new Collection($allWidgets);
    }

    protected static function setLayout(array $classes): array
    {
        $allWidgets = [];

        foreach ($classes as $widget) {
            $widgetClass = new $widget();
            if ($widgetClass->enabled()) {
                $allWidgets[] = $widgetClass->form();
            }
        }

        return $allWidgets;
    }
}
