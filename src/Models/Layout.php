<?php

namespace LaraZeus\DynamicDashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property array $widgets
 * @property string $layout_title
 * @property string $layout_slug
 */
class Layout extends Model
{
    protected $guarded = [];

    protected $casts = [
        'widgets' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
