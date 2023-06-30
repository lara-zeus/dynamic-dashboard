<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\Rain\Widgets\Widget;

class MenuWidget extends Widget implements \LaraZeus\Rain\Contracts\Widget
{
    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class);
    }

    public function form(): Builder\Block
    {
        return Builder\Block::make('Menu')
            ->label(__('Menu'))
            ->schema([
                Tabs::make('Menu_tabs')
                    ->schema([
                        Tabs\Tab::make('Menu')
                            ->label(__('Menu'))
                            ->schema([
                                Select::make('menu_slug')
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        \RyanChandler\FilamentNavigation\Models\Navigation::pluck('name', 'handle')
                                    ),
                                Select::make('menu_dir')
                                    ->options([
                                        'vertical' => __('vertical'),
                                        'horizontal' => __('horizontal'),
                                    ]),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }

    public function viewData(array $data): array
    {
        return [
            // @phpstan-ignore-next-line
            'menu' => \RyanChandler\FilamentNavigation\Facades\FilamentNavigation::get($data['menu_slug']),
        ];
    }
}
