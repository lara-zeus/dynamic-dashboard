<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;

class CreateLayout extends CreateRecord
{
    protected static string $resource = LayoutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        return parent::mutateFormDataBeforeCreate($data);
    }
}
