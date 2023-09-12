<?php

namespace LaraZeus\Rain\Widgets\Classes;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\Rain\Widgets\Widget;

class LibraryWidget extends Widget implements \LaraZeus\Rain\Contracts\Widget
{
    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class);
    }

    public function form(): Builder\Block
    {
        return Builder\Block::make('Library')
            ->label(__('Library'))
            ->schema([
                Tabs::make('Library_tabs')
                    ->schema([
                        Tabs\Tab::make('Library')
                            ->label(__('Library'))
                            ->schema([
                                Select::make('library_slug')
                                    ->required()
                                    ->options(
                                        // @phpstan-ignore-next-line
                                        \LaraZeus\Sky\SkyPlugin::get()->getTagModel()::query()
                                            ->where('type', 'library')
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
            'library' => ($data['library_slug'] !== null) ? \LaraZeus\Sky\SkyPlugin::get()->getModel('Library')::withAnyTags([$data['library_slug']], 'library')->get() : null,
        ];
    }
}
