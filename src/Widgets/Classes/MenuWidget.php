<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;

class MenuWidget implements \LaraZeus\DynamicDashboard\Contracts\Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class) && Filament::hasPlugin('zeus-sky');
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
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        \LaraZeus\Sky\SkyPlugin::get()->getModel('Navigation')::pluck('name', 'handle')
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
            // @phpstan-ignore-next-line
            'menu' => ($data['menu_slug'] !== null) ? config('zeus-sky.models.Navigation')::fromHandle($data['menu_slug']) : null,
        ];
    }
}
