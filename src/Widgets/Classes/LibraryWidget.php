<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;

class LibraryWidget implements \LaraZeus\DynamicDashboard\Contracts\Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(\LaraZeus\Sky\SkyServiceProvider::class) && Filament::hasPlugin('zeus-sky');
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
                                        \LaraZeus\Sky\SkyPlugin::get()->getModel('Tag')::query()
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
            'library' => ($data['library_slug'] !== null) ? config('zeus-sky.models.Library')::withAnyTags([$data['library_slug']], 'library')->get() : null,
        ];
    }
}
