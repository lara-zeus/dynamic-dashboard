<?php

namespace LaraZeus\Rain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property array $widgets
 * @property string $layout_title
 * @property string $layout_slug
 */
class Widgets extends Model
{
    protected $guarded = [];

    protected $casts = [
        'widgets' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
