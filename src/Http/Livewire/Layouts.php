<?php

namespace LaraZeus\Rain\Http\Livewire;

use Illuminate\View\View;
use LaraZeus\Rain\Models\Layout;
use Livewire\Component;

class Layouts extends Component
{
    public Layout $layout;

    public function mount(string $slug = null): void
    {
        if ($slug === null) {
            $this->layout = config('zeus-rain.models.layout')::where('layout_slug', config('zeus-rain.default_layout'))->firstOrFail();
        } else {
            $this->layout = config('zeus-rain.models.layout')::where('layout_slug', $slug)->firstOrFail();
        }
    }

    public function render(): View
    {
        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus-rain.site_title'))
            ->description(config('zeus-rain.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-rain.color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('rainTheme') . '.layouts')
            ->layout(config('zeus.layout'));
    }
}
