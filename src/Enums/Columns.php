<?php

namespace LaraZeus\DynamicDashboard\Enums;

use Filament\Support\Contracts\HasLabel;

enum Columns: string implements HasLabel
{
    case headerColumn = 'headerColumn';
    case leftColumn = 'leftColumn';
    case middleColumn = 'middleColumn';
    case rightColumn = 'rightColumn';
    case footerColumn = 'footerColumn';

    public function getLabel(): string
    {
        return __(str($this->name)->replace('Column', ''));
    }

    public function span(): int
    {
        return match ($this) {
            self::headerColumn, self::footerColumn => 12,
            self::leftColumn, self::rightColumn => 3,
            self::middleColumn => 6,
        };
    }

    public function class(): string
    {
        return match ($this) {
            self::headerColumn, self::footerColumn => 'md:col-span-12',
            self::leftColumn, self::rightColumn => 'md:col-span-3',
            self::middleColumn => 'md:col-span-6',
        };
    }
}
