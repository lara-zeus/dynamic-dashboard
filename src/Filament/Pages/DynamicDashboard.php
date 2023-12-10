<?php

namespace LaraZeus\Rain\Filament\Pages;

use Filament\Actions\Action;
use LaraZeus\Rain\Filament\Resources\LayoutResource\Pages\EditLayout;
use LaraZeus\Rain\Models\Layout;
use LaraZeus\Rain\RainPlugin;

class DynamicDashboard extends \Filament\Pages\Dashboard
{
    public ?Layout $rainLayout;

    protected static string $view = 'zeus::filament.pages.dynamic-dashboard';

    public function mount(?string $slug = null): void
    {
        $defaultLayout = $slug ?? RainPlugin::get()->getDefaultLayout();

        $this->rainLayout = RainPlugin::get()->getModel('Layout')::query()
            ->where('is_active', 1)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($this->rainLayout === null) {
            $this->rainLayout = RainPlugin::get()->getModel('Layout')::query()
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
                ->url(fn () => EditLayout::getUrl(['record' => $this->rainLayout->id])),
        ];
    }
}
