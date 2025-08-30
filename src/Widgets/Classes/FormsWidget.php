<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Forms\Components\Builder\Block;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\BoltServiceProvider;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;
use LaraZeus\DynamicDashboard\Contracts\Widget;

class FormsWidget implements Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(BoltServiceProvider::class);
    }

    public function form(): Block
    {
        return Block::make('Forms')
            ->label(__('Forms'))
            ->schema([
                Tabs::make('Forms_tabs')
                    ->schema([
                        Tab::make('Forms')
                            ->label(__('Forms'))
                            ->schema([
                                Select::make('form_slug')
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        BoltPlugin::getModel('Form')::pluck('name', 'slug')
                                    ),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
