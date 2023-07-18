<?php

namespace LaraZeus\Rain\Filament\Resources\LayoutResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Rain\Filament\Resources\LayoutResource;

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
