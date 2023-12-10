<?php

namespace LaraZeus\DynamicDashboard\Facades;

use Filament\Facades\Filament;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use LaraZeus\DynamicDashboard\Contracts\Widget;
use Symfony\Component\Finder\Finder;

class DynamicDashboard extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'dynamic-dashboard';
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
        $coreWidgets = self::collectWidgets(__DIR__ . '/../Widgets/Classes', 'LaraZeus\\DynamicDashboard\\Widgets\\Classes\\');
        $appWidgets = self::collectWidgets(app_path('Zeus/Widgets'), 'App\\Zeus\\Widgets\\');

        $allFilamentWidgets = self::filamentWidgets();

        $widgets = collect();

        if (! $coreWidgets->isEmpty()) {
            $widgets = $widgets->merge($coreWidgets);
        }

        if (! $appWidgets->isEmpty()) {
            $widgets = $widgets->merge($appWidgets);
        }

        if (! $allFilamentWidgets->isEmpty()) {
            $widgets = $widgets->merge($allFilamentWidgets);
        }

        return $widgets->sortBy('sort')->toArray();
    }

    public static function filamentWidgets(): Collection
    {
        $filamentWidgetClasses = Filament::getCurrentPanel()->getWidgetDirectories();
        $filamentWidgetNamespace = Filament::getCurrentPanel()->getWidgetNamespaces();

        $allFilamentWidgets = collect();
        $filamentWidgets = array_combine($filamentWidgetClasses, $filamentWidgetNamespace);

        foreach ($filamentWidgets as $class => $namespace) {
            $loadWidget = self::loadClasses($class, $namespace . '\\');
            $allFilamentWidgets->push(self::setLayout($loadWidget)[0]);
        }

        return $allFilamentWidgets;
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

            if ($widgetClass instanceof Widget && $widgetClass->enabled()) {
                $allWidgets[] = $widgetClass->form();
            }
        }

        return $allWidgets;
    }
}
