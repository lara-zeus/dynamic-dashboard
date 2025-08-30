<?php

use LaraZeus\DynamicDashboard\Enums\Columns;
use LaraZeus\DynamicDashboard\Models\Layout;

return [
    'domain' => null,

    /**
     * set the default path for the blog homepage.
     */
    'prefix' => 'dynamic-dashboard',

    /**
     * the middleware you want to apply on all the blog routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * you can overwrite any model and use your own
     * you can also configure the model per panel in your panel provider using:
     * ->skyModels([ ... ])
     */
    'models' => [
        'Layout' => Layout::class,
    ],

    'enums' => [
        'Columns' => Columns::class,
    ],

    'defaultLayout' => 'new-page',
];
