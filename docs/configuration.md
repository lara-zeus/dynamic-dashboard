---
title: Configuration
weight: 3
---

## Configuration

to configure the plugin Dynamic Dashboard, you can pass the configuration to the plugin in `adminPanelProvider`

these all the available configuration, and their defaults values

```php
DynamicDashboardPlugin::make()
    ->models([
        'Layout' => \LaraZeus\DynamicDashboard\Models\Layout::class,
        'Columns' => \LaraZeus\DynamicDashboard\Models\Columns::class
    ])
    
    ->uploadDisk('public')
    ->uploadDirectory('layouts')
    
    ->navigationGroupLabel('Dynamic Dashboard')
    
    ->hideLayoutResource()
    
    ->defaultLayout('new-page')
```
