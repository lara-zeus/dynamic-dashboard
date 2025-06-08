<?php

namespace LaraZeus\DynamicDashboard\Widgets\Classes;

use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;
use LaraZeus\DynamicDashboard\Contracts\Widget;
use LaraZeus\Sky\SkyPlugin;
use LaraZeus\Sky\SkyServiceProvider;

class LibraryWidget implements Widget
{
    use InteractWithWidgets;

    public function enabled(): bool
    {
        return class_exists(SkyServiceProvider::class) && Filament::hasPlugin('zeus-sky');
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
                                        SkyPlugin::get()->getModel('Tag')::query()
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
            'library' => ($data['library_slug'] !== null) ? config('zeus-sky.models.Library')::withAnyTags([$data['library_slug']], 'library')->get() : null,
        ];
    }
}
