---
title: Installation
weight: 2
---

## Composer

You can install the package via composer:

```bash
composer require lara-zeus/rain
```

## publish
for your convenient, we create a one command to publish them all:

```bash
php artisan rain:publish
```

the command will publish the following: config,views and translations.
and zeus assets.

you can pass `--force` option to force publishing all the files, helps if you're updating the package

## Migrations
to publish the migrations files

```bash
php artisan vendor:publish --tag=zeus-dynamic-dashboard-migrations
```

## Assets

to publish the assets files for the frontend:

```bash
php artisan vendor:publish --tag=zeus-assets
```

## Run Migration

finally, run the migration:

```bash
php artisan migrate
```
