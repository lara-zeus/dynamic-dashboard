---
title: Customization
weight: 4
---

to customize the layout, you can change the default layout in the `zeus.php` config file

```php
'layout' => 'zeus::components.app',
```

## Publishing the default layout

or if you don't have a layout yet, you can publish the default one:

```bash
php artisan vendor:publish --tag=zeus-views
```

## Publishing Translations

to customize the translations:

```bash
php artisan vendor:publish --tag=zeus-dynamic-dashboard-translations
```

