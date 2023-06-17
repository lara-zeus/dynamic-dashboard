<?php

namespace LaraZeus\Rain\Widgets;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class Widget
{
    public function enabled(): bool
    {
        return true;
    }

    public function render($data): string
    {
        $data['widgetViewData'] = $this->viewData($data);

        return view(app('rain-theme') . '.widgets.' . last(explode('\\', $data['widget'])))
            ->with('data', $data)
            ->render();
    }

    public function viewData($data): array
    {
        return [];
    }

    public function defaultOptionsTab(): Tab
    {
        return Tab::make('options')
            ->label(__('options'))
            ->schema([
                TextInput::make('title')
                    ->helperText(__('optional'))
                    ->label(__('widget title'))
                    ->nullable(),
                TextInput::make('sort')->default(1)->label(__('order')),
                Hidden::make('widget')->default(get_called_class()),
            ]);
    }
}
