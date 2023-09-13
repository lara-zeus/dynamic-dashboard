<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\Rain\Widgets\Widget;

class FaqWidget extends Widget
{
    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class);
    }

    public function form(): Builder\Block
    {
        return Builder\Block::make('Faq')
            ->label(__('Faq'))
            ->schema([
                Tabs::make('Faq_tabs')
                    ->schema([
                        Tabs\Tab::make('Faq')
                            ->label(__('Faq'))
                            ->schema([
                                Select::make('faq_cat')
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        \LaraZeus\Sky\SkyPlugin::get()->getModel('Tag')::query()
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
            // @phpstan-ignore-next-line
            'faqs' => ($data['faq_cat'] !== null) ? \LaraZeus\Sky\SkyPlugin::get()->getModel('Faq')::withAnyTags([$data['faq_cat']], 'faq')->get() : null,
        ];
    }
}
