<?php

namespace LaraZeus\Rain\Filament\Resources\LayoutResource\Pages;

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
                ->url(fn () => route('landing-page', $this->rainLayout->layout_slug))
                ->openUrlInNewTab(),
        ];
    }
}
