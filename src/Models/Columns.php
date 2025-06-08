<?php

namespace LaraZeus\DynamicDashboard\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $key
 * @property string $name
 * @property string $class
 */
class Columns extends Model
{
    use \Sushi\Sushi;

    public function getRows(): array
    {
        return [
            ['key' => 'headerColumn', 'span' => '12', 'name' => __('top')],
            ['key' => 'leftColumn', 'span' => '3', 'name' => __('left')],
            ['key' => 'middleColumn', 'span' => '6', 'name' => __('middle')],
            ['key' => 'rightColumn', 'span' => '3', 'name' => __('right')],
            ['key' => 'footerColumn', 'span' => '12', 'name' => __('bottom')],
        ];
    }
}
