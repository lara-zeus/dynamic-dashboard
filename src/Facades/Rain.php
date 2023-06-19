<?php

namespace LaraZeus\Rain\Facades;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Finder\Finder;

class Rain extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'rain';
    }

    public static function loadClasses($path, $namespace): array
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
        Cache::forget('rain.widgets');
        if (app()->isLocal()) {
            Cache::forget('rain.widgets');
        }

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

    public static function collectWidgets($path, $namespace): \Illuminate\Support\Collection
    {
        if (! is_dir($path)) {
            return collect();
        }

        $classes = self::loadClasses($path, $namespace);
        $allWidgets = self::setLayout($classes);

        return collect($allWidgets);
    }

    protected static function setLayout($classes): array
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
