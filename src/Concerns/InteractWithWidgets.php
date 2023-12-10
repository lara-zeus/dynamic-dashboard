<?php

namespace LaraZeus\DynamicDashboard\Concerns;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;

trait InteractWithWidgets
{
    public function enabled(): bool
    {
        return true;
    }

    public function renderWidget(array $data): string | View
    {
        $widgetClass = new $data['widget'];

        if ($widgetClass instanceof Widget) {
            return Blade::render('@livewire(' . $data['widget'] . '::class)');
        }

        $data = array_merge($data, $this->viewData($data));

        return view(app('dynamicDashboardTheme') . '.widgets.' . last(explode('\\', $data['widget'])))
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
            ->label($this->getHeading())
            ->schema([
                Tabs::make($widgetId . '_tabs')
                    ->schema([
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
