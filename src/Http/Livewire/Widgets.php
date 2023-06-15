<?php

namespace LaraZeus\Rain\Http\Livewire;

use Livewire\Component;

class Widgets extends Component
{
    public $widget;

    public function mount($widgetID = null)
    {
        if ($this->widget === null) {
            $this->widget = \LaraZeus\Rain\Models\Widgets::first();
        } else {
            $this->widget = \LaraZeus\Rain\Models\Widgets::findOrFail($widgetID);
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
