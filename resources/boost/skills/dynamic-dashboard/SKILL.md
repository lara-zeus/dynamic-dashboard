---
name: zeus-dynamic-dashboard
description: Use when installing, configuring, or creating custom widgets and layouts with lara-zeus/dynamic-dashboard in Laravel/Filament.
---

# Lara Zeus Dynamic Dashboard (`lara-zeus/dynamic-dashboard`)

## Overview & Requirements
`lara-zeus/dynamic-dashboard` manages configurable widget layouts (`Layout`) for Filament dashboard pages and public Livewire landing pages.
- **PHP**: `^8.1`
- **Dependencies**: `lara-zeus/core` (`^5.0`), `lara-zeus/filament-plugin-tools` (`^3.0.3`)

## Installation
```bash
composer require lara-zeus/dynamic-dashboard
php artisan dynamic-dashboard:publish
php artisan vendor:publish --tag=zeus-dynamic-dashboard-migrations
php artisan migrate
```
`php artisan dynamic-dashboard:publish` (`--force` supported) publishes `zeus-dynamic-dashboard-translations`, `zeus-dynamic-dashboard-config`, `zeus-config`, `zeus-views`, and `zeus-assets`.

## Configuration & Migrations
Published migration: `create_layouts_table`.
Config file `config/zeus-dynamic-dashboard.php`:
- `domain` (`null`), `prefix` (`'dynamic-dashboard'`), `middleware` (`['web']`)
- `models.Layout` (`LaraZeus\DynamicDashboard\Models\Layout::class`)
- `resources.Layout` (`LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource::class`)
- `enums.Columns` (`LaraZeus\DynamicDashboard\Enums\Columns::class`)
- `defaultLayout` (`'new-page'`)

## Filament Panel Registration
Register `LaraZeus\DynamicDashboard\DynamicDashboardPlugin` in your PanelProvider:
```php
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Enums\Columns;
use LaraZeus\DynamicDashboard\Models\Layout;

->plugins([
    DynamicDashboardPlugin::make()
        ->models([
            'Layout' => Layout::class,
        ])
        ->enums([
            'Columns' => Columns::class,
        ])
        ->uploadDisk('public')
        ->uploadDirectory('layouts')
        ->navigationGroupLabel('Dynamic Dashboard')
        ->setDefaultLayout('new-page'),
])
```
To use the dynamic layout as your Filament panel dashboard, register `LaraZeus\DynamicDashboard\Filament\Pages\DynamicDashboard::class` (or `DynamicDashboardPage::class`) in `->pages([...])`.

## Core Usage
### Creating Custom Widgets
Generate a widget class in `app/Zeus/Widgets/{Name}Widget.php` and its Blade view:
```bash
php artisan make:zeus-widget Stats
```
Custom widgets implement `LaraZeus\DynamicDashboard\Contracts\Widget` (`enabled()`, `renderWidget(array $data)`, `form()`, `viewData(array $data)`) and can use `LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets`.

### Frontend Route & Livewire
- **Route**: `GET /{prefix}/{slug?}` named `landing-page` (renders `LaraZeus\DynamicDashboard\Livewire\Layouts`).
- **Livewire component**: `<livewire:landing />` (registered as `landing`).

## Common Pitfalls
- **Wrong plugin method names**: Use `->setDefaultLayout(...)` (not `->defaultLayout(...)`) and `->hideResources([LayoutResource::class])` (not `->hideLayoutResource()`).
- **Wrong Widget interface namespace**: Implement `LaraZeus\DynamicDashboard\Contracts\Widget` (not `Widgets\Widget`).
- **No matching active layout**: `Dash::mount()` calls `firstOrFail()` on `layout_slug` matching `$defaultLayout` when the user has no personal active layout — ensure a default active layout record exists in `layouts`.
