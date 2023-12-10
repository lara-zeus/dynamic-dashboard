<?php

namespace LaraZeus\DynamicDashboard\Filament\Pages;

use Filament\Actions\Action;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use LaraZeus\DynamicDashboard\Filament\Resources\LayoutResource\Pages\EditLayout;
use LaraZeus\DynamicDashboard\Models\Layout;

class DynamicDashboard extends \Filament\Pages\Dashboard
{
    public ?Layout $dashLayout;

    protected static string $view = 'zeus::filament.pages.dynamic-dashboard';

    public function mount(?string $slug = null): void
    {
        $defaultLayout = $slug ?? DynamicDashboardPlugin::get()->getDefaultLayout();

        $this->dashLayout = DynamicDashboardPlugin::get()->getModel('Layout')::query()
            ->where('is_active', 1)
            ->where('user_id', auth()->user()->id)
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
