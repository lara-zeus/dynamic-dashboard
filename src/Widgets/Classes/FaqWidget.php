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

class FaqWidget implements Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(SkyServiceProvider::class) && Filament::hasPlugin('zeus-sky');
    }

    public function form(): Block
    {
        return Block::make('Faq')
            ->label(__('Faq'))
            ->schema([
                Tabs::make('Faq_tabs')
                    ->schema([
                        Tab::make('Faq')
                            ->label(__('Faq'))
                            ->schema([
                                Select::make('faq_cat')
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        SkyPlugin::get()->getModel('Tag')::query()
                                            ->where('type', 'faq')
                                            ->get()
                                            ->pluck('name', 'slug')
                                    ),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }

    public function viewData(array $data): array
    {
        return [
            'faqs' => ($data['faq_cat'] !== null) ? config('zeus-sky.models.Faq')::withAnyTags([$data['faq_cat']], 'faq')->get() : null,
        ];
    }
}
