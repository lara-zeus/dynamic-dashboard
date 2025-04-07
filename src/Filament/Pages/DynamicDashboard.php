<?php

namespace LaraZeus\DynamicDashboard\Filament\Pages;

use LaraZeus\DynamicDashboard\Filament\Pages\Concerns\Dash;
use LaraZeus\DynamicDashboard\Models\Layout;

class DynamicDashboard extends \Filament\Pages\Dashboard
{
    use Dash;

    public ?Layout $dashLayout;

    protected string $view = 'zeus::filament.pages.dynamic-dashboard';
}
