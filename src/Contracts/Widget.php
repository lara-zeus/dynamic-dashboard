<?php

namespace LaraZeus\DynamicDashboard\Contracts;

use Filament\Forms\Components\Builder\Block;
use Illuminate\Contracts\View\View;

interface Widget
{
    public function enabled(): bool;

    public function renderWidget(array $data): string | View;

    public function form(): Block;

    public function viewData(array $data): array;
}
