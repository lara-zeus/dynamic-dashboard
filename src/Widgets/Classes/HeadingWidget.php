<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;
use LaraZeus\Rain\Widgets\Widget;

class HeadingWidget extends Widget implements \LaraZeus\Rain\Contracts\Widget
{
    public function form(): Builder\Block
    {
        return Builder\Block::make('paragraph')
            ->label(__('Paragraph'))
            ->schema([
                Tabs::make('paragraph_tabs')
                    ->schema([
                        Tabs\Tab::make('paragraph')
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
