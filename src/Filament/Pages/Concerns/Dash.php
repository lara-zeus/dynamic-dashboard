<?php

namespace LaraZeus\DynamicDashboard\Filament\Pages\Concerns;

use Filament\Actions\Action;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages\EditLayout;

trait Dash
{
    public function mount(?string $slug = null): void
    {
        $defaultLayout = $slug ?? DynamicDashboardPlugin::get()->getDefaultLayout();

        $this->dashLayout = DynamicDashboardPlugin::get()->getModel('Layout')::query()
            ->where('is_active', 1)
            ->where('user_id', auth()->user()?->id ?? 0)
            ->first();

        if ($this->dashLayout === null) {
            $this->dashLayout = DynamicDashboardPlugin::get()->getModel('Layout')::query()
                ->where('is_active', 1)
                ->where('layout_slug', $defaultLayout)
                ->firstOrFail();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->tooltip('Edit Dashboard')
                ->icon('heroicon-m-pencil-square')
                ->iconButton()
                ->url(fn () => EditLayout::getUrl(['record' => $this->dashLayout->id])),
        ];
    }
}
