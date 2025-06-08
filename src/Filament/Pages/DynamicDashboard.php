<?php

namespace LaraZeus\DynamicDashboard\Filament\Pages;

use Filament\Pages\Dashboard;
use LaraZeus\DynamicDashboard\Filament\Pages\Concerns\Dash;
use LaraZeus\DynamicDashboard\Models\Layout;

class DynamicDashboard extends Dashboard
{
    use Dash;

    public ?Layout $dashLayout;

    protected string $view = 'zeus::filament.pages.dynamic-dashboard';
}
