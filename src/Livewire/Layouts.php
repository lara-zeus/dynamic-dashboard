<?php

namespace LaraZeus\Rain\Livewire;

use Illuminate\View\View;
use LaraZeus\Rain\Models\Layout;
use LaraZeus\Rain\RainPlugin;
use Livewire\Component;

class Layouts extends Component
{
    public Layout $rainLayout;

    public function mount(?string $slug = null): void
    {
        $l = $slug ?? RainPlugin::get()->getDefaultLayout();
        $this->rainLayout = RainPlugin::get()->getModel('Layout')::where('layout_slug', $l)->firstOrFail();
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

        return view(app('rainTheme') . '.layouts')
            ->layout(config('zeus.layout'));
    }
}
