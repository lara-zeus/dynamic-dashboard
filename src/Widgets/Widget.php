<?php

namespace LaraZeus\Rain\Widgets;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class Widget implements \LaraZeus\Rain\Contracts\Widget
{
    public function enabled(): bool
    {
        return true;
    }

    public function render(array $data): string
    {
        return view(app('rainTheme') . '.widgets.' . last(explode('\\', $data['widget'])))
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
        return Block::make('Faq')
            ->label(__('Faq'))
            ->schema([
                Tabs::make('Faq_tabs')
                    ->schema([
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
