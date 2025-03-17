<?php

namespace LaraZeus\DynamicDashboard\Filament\Pages;

use Filament\Pages\Page;
use LaraZeus\DynamicDashboard\Filament\Pages\Concerns\Dash;
use LaraZeus\DynamicDashboard\Models\Layout;

class DynamicDashboardPage extends Page
{
    use Dash;

    public ?Layout $dashLayout;

    protected static string $view = 'zeus::filament.pages.dynamic-dashboard';
}
