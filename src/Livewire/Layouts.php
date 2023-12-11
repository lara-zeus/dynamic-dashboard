<?php

namespace LaraZeus\DynamicDashboard\Livewire;

use Illuminate\View\View;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Models\Layout;
use Livewire\Component;

class Layouts extends Component
{
    public Layout $dashLayout;

    public function mount(?string $slug = null): void
    {
        $l = $slug ?? DynamicDashboardPlugin::get()->getDefaultLayout();
        $this->dashLayout = DynamicDashboardPlugin::get()->getModel('Layout')::where('layout_slug', $l)->firstOrFail();
    }

    public function render(): View
    {
        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus.site_title'))
            ->description(config('zeus.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('dynamic-dashboardTheme') . '.layouts')
            ->layout(config('zeus.layout'));
    }
}
