---
title: Configuration
weight: 3
---

## Configuration

to configure the plugin Rain, you can pass the configuration to the plugin in `adminPanelProvider`

these all the available configuration, and their defaults values

```php
RainPlugin::make()
    ->rainPrefix('rain')
    ->rainMiddleware(['web'])
    ->rainModels([
        'Layout' => \LaraZeus\Rain\Models\Layout::class,
        'Columns' => \LaraZeus\Rain\Models\Columns::class
    ])
    ->uploadDisk('public')
    ->uploadDirectory('layouts')
    ->navigationGroupLabel('RaRainin')
    ->defaultLayout('new-page')
```
