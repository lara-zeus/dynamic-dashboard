<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;
use LaraZeus\DynamicDashboard\Contracts\Widget;

class HeadingWidget implements Widget
{
    use InteractWithWidgets;

    public function form(): Block
    {
        return Block::make('paragraph')
            ->label(__('Paragraph'))
            ->schema([
                Tabs::make('paragraph_tabs')
                    ->schema([
                        Tab::make('paragraph')
                            ->label(__('Paragraph'))
                            ->schema([
                                MarkdownEditor::make('content')
                                    ->label(__('content'))
                                    ->required(),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
