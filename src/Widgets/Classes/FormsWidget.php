<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\Rain\Widgets\Widget;

class FormsWidget extends Widget implements \LaraZeus\Rain\Contracts\Widget
{
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
                                        config('zeus-bolt.models.Form')::pluck('name', 'slug')
                                    ),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
