<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Forms\Components\Builder\Block;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;
use LaraZeus\DynamicDashboard\Contracts\Widget;
use LaraZeus\Sky\SkyPlugin;
use LaraZeus\Sky\SkyServiceProvider;

class MenuWidget implements Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(SkyServiceProvider::class) && Filament::hasPlugin('zeus-sky');
    }

    public function form(): Block
    {
        return Block::make('Menu')
            ->label(__('Menu'))
            ->schema([
                Tabs::make('Menu_tabs')
                    ->schema([
                        Tab::make('Menu')
                            ->label(__('Menu'))
                            ->schema([
                                Select::make('menu_slug')
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        SkyPlugin::get()->getModel('Navigation')::pluck('name', 'handle')
                                    ),
                                Select::make('menu_dir')
                                    ->default('vertical')
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
            'menu' => ($data['menu_slug'] !== null) ? config('zeus-sky.models.Navigation')::fromHandle($data['menu_slug']) : null,
        ];
    }
}
