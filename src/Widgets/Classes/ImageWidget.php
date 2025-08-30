<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;
use LaraZeus\DynamicDashboard\Contracts\Widget;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;

class ImageWidget implements Widget
{
    use InteractWithWidgets;

    public function form(): Block
    {
        return Block::make('image')
            ->label(__('Image'))
            ->schema([
                Tabs::make('image_tabs')
                    ->schema([
                        Tab::make('image')
                            ->label(__('Image'))
                            ->schema([
                                FileUpload::make('url')
                                    ->label(__('Image'))
                                    ->disk(DynamicDashboardPlugin::get()->getUploadDisk())
                                    ->directory(DynamicDashboardPlugin::get()->getUploadDirectory())
                                    ->image()
                                    ->imageEditor()
                                    ->required(),

                                TextInput::make('alt')
                                    ->label(__('image alt text'))
                                    ->required(),
                            ]),

                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }
}
