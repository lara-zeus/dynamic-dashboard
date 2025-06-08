<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource;
use LaraZeus\DynamicDashboard\Models\Layout;

class EditLayout extends EditRecord
{
    protected static string $resource = LayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label(__('View'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('view form'))
                ->color('warning')
                ->url(fn (Layout $record) => route('landing-page', ['slug' => $record->layout_slug]))
                ->openUrlInNewTab(),
        ];
    }
}
