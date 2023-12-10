<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;

class FormsWidget implements \LaraZeus\DynamicDashboard\Contracts\Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Bolt\BoltServiceProvider::class);
    }

    public function form(): Builder\Block
    {
        return Builder\Block::make('Forms')
            ->label(__('Forms'))
            ->schema([
                Tabs::make('Forms_tabs')
                    ->schema([
                        Tabs\Tab::make('Forms')
                            ->label(__('Forms'))
                            ->schema([
                                Select::make('form_slug')
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        \LaraZeus\Bolt\BoltPlugin::getModel('Form')::pluck('name', 'slug')
                                    ),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
