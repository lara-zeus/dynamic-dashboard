<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use LaraZeus\Rain\Widgets\Widget;

class ImageWidget extends Widget
{
    public bool $disabled = false;

    public function form()
    {
        return Builder\Block::make('image')
            ->icon('heroicon-o-bookmark')
            ->label('صورة')
            ->schema([
                Placeholder::make('show-' . __CLASS__)->label('عرض صورة كاعلان'),
                TextInput::make('title')
                    ->helperText('تقدر تتركه فارغ')
                    ->label('العنوان')
                    ->nullable(),
                TextInput::make('sort')->default(1)->label('الترتيب في العرض'),
                Hidden::make('widget')->default(__CLASS__),
                FileUpload::make('url')
                    ->label('الصورة')
                    ->disk(config('zeus-rain.uploads.disk'))
                    ->directory(config('zeus-rain.uploads.directory'))
                    ->image()
                    ->required(),
                TextInput::make('alt')
                    ->label('عنوان الصورة')
                    ->required(),
            ]);
    }
}
