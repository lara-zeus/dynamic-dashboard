<?php

namespace LaraZeus\DynamicDashboard\Concerns;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

trait InteractWithWidgets
{
    public function enabled(): bool
    {
        return true;
    }

    public function renderWidget(array $data): string | View
    {
        $widgetClass = new $data['widget'];

        $view = app('dynamic-dashboardTheme') . '.widgets.' . last(explode('\\', $data['widget']));

        if ($widgetClass instanceof Widget) {
            $view = app('dynamic-dashboardTheme') . '.widgets.filament';
            //return Blade::render('');
        }

        $data = array_merge($data, $this->viewData($data));

        return view($view)
            ->with('data', array_merge($data, $this->viewData($data)))
            ->render();
    }

    public function viewData(array $data): array
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

    public function form(): Block
    {
        $widgetId = str(__CLASS__)->explode('\\')->last();

        return Block::make($widgetId)
            ->label(str($widgetId)->snake(' ')->title())
            ->schema([
                Tabs::make($widgetId . '_tabs')
                    ->schema([
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
