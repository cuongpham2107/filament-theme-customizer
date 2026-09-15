<?php

namespace CuongPham\FilamentThemeCustomizer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThemeSetting extends Model
{
    protected $table = 'filament_theme_settings';

    protected $fillable = [
        'user_id',
        'panel',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        /** @var class-string<Model> $userModel */
        $userModel = config('auth.providers.users.model', 'App\\Models\\User');

        return $this->belongsTo($userModel);
    }
}
