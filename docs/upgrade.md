---
title: Upgrade
weight: 6
---

to upgrade to v3, the name and the name space changed from `Rain` to `DynamicDashboard`

1- so first publish the config:

```bash
php artisna vendor:publish --tag=zeus-dynamic-dashboard-config
```

this will crate the new config file `zeus-dynamic-dashboard.php`, and you can move your configuration from the old file `zeus-rain`

2- change the call in the `plugins` array in your panel provider

```php
DynamicDashboardPlugin::make()
```

3- run the update script, since the namespace has changed, you need to run this command in the production to update the class names

>make sure to backup your database

```bash
php artisan dynamic-dashboard:update-class
```

this will change `LaraZeus\Rain` to `LaraZeus\DynamicDashboard`