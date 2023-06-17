<?php

namespace LaraZeus\Rain\Contracts;

use Filament\Forms\Components\Builder\Block;

interface Widget
{
    public function enabled(): bool;

    public function render($data): string;

    public function form() :Block;
}
