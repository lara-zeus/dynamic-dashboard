<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use LaraZeus\Rain\Widgets\Widget;

class HeadingWidget extends Widget
{
    public function form()
    {
        return Builder\Block::make('paragraph')
            ->icon('heroicon-o-bookmark')
            ->label('فقرة نصية')
            ->schema([
                Placeholder::make('show-' . __CLASS__)->label('يمكنك عرض اي نص تريده'),

                TextInput::make('title')
                    ->helperText('تقدر تتركه فارغ')
                    ->label('العنوان')
                    ->nullable(),
                TextInput::make('sort')->default(1)->label('الترتيب في العرض'),
                Hidden::make('widget')->default(__CLASS__),

                MarkdownEditor::make('content')
                    ->label('المحتوى')
                    ->required(),
            ]);
    }
}
