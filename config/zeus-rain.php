<?php

return [
    /**
     * set the default path for the layout page.
     */
    'path' => 'rain',

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * customize the models
     */
    'models' => [
        'layout' => \LaraZeus\Rain\Models\Layout::class,
        'columns' => \LaraZeus\Rain\Models\Columns::class,
    ],

    /**
     * set the default upload options for departments logo.
     */
    'uploads' => [
        'disk' => 'public',
        'directory' => 'layouts',
    ],

    /**
     * this will be setup the default seo site title. read more about it in 'laravel-seo'.
     */
    'site_title' => config('app.name', 'Laravel'),

    /**
     * this will be setup the default seo site description. read more about it in 'laravel-seo'.
     */
    'site_description' => config('app.name', 'Laravel'),

    /**
     * this will be setup the default seo site color theme. read more about it in 'laravel-seo'.
     */
    'color' => '#F5F5F4',

    /**
     * Navigation Group Label
     */
    'navigation_group_label' => 'Rain',

    /**
     * default layout slug
     */
    'default_layout' => 'home-page',
];
