<?php

namespace LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages;

use Filament\Actions\Action;

class EditLayout extends CreateLayout
{
    public function getTitle(): string
    {
        return __('edit layout');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label(__('View'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->tooltip(__('view form'))
                ->color('warning')
                ->url(fn () => route('landing-page', $this->dashLayout->layout_slug))
                ->openUrlInNewTab(),
        ];
    }
}
