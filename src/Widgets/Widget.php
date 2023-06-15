<?php

namespace LaraZeus\Rain\Widgets;

class Widget
{
    public bool $disabled = false;

    public function render($data): string
    {
        return view('zeus-rain::themes.widgets.' . last(explode('\\', $data['data']['widget'])))
            ->with('data', $data)
            ->render();
    }
}
