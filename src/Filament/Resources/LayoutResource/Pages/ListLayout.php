<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;

class ListLayout extends ListRecords
{
    protected static string $resource = LayoutResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
