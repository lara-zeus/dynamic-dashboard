<?php

namespace LaraZeus\Rain\Http\Livewire;

use Livewire\Component;

class Widgets extends Component
{
    public $widget;

    public function mount($slug = null)
    {
        if ($slug === null) {
            $this->widget = \LaraZeus\Rain\Models\Widgets::where('layout_slug', config('zeus-rain.default_layout'))->firstOrFail();
        } else {
            $this->widget = \LaraZeus\Rain\Models\Widgets::where('layout_slug', $slug)->firstOrFail();
        }
    }

    public function render()
    {
        seo()
            ->site(config('app.name', 'Laravel'))
            ->title(config('zeus-rain.site_title'))
            ->description(config('zeus-rain.site_description'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-rain.color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('rain-theme') . '.widgets')
            ->layout(config('zeus-rain.layout'));
    }
}
