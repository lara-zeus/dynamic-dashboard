---
title: Create Widget
weight: 5
---

## Create Custom Widget

Add any custom widget you want.

Create the widget using the following command, passing the name of the widget:

```bash
php artisan make:zeus-widget Forms
```

this will create two files:
`FormsWidget.php`
to define all fields you want to store it with the widget

`FormsWidget.blade.php`
the view to be rendered on the frontend

## Customization
check out the contract `LaraZeus\DynamicDashboard\Widgets\Widget.php` and see all the available methods.
