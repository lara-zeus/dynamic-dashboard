<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Select;
use LaraZeus\Rain\Widgets\Widget;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Tabs;

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
                                    ->options(
                                        config('zeus-bolt.models.Form')::pluck('name','slug')
                                    )
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}

