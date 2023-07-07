<?php

namespace LaraZeus\Rain\Models;

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
            ['key' => 'headerColumn', 'name' => __('top'), 'class' => 'w-full col-span-12 md:col-span-12'],
            ['key' => 'rightColumn', 'name' => __('right'), 'class' => 'w-1/4 col-span-12 md:col-span-3'],
            ['key' => 'middleColumn', 'name' => __('middle'), 'class' => 'w-2/4 col-span-12 md:col-span-6'],
            ['key' => 'leftColumn', 'name' => __('left'), 'class' => 'w-1/4 col-span-12 md:col-span-3'],
            ['key' => 'footerColumn', 'name' => __('bottom'), 'class' => 'w-full col-span-12 md:col-span-12'],
        ];
    }
}
