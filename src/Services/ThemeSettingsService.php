<?php

namespace CuongPham\FilamentThemeCustomizer\Services;

use CuongPham\FilamentThemeCustomizer\Models\ThemeSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class ThemeSettingsService
{
    public static function getDefaultSettings(): array
    {
        return [
            'theme' => 'modern',
            'surface' => 'default',
            'contentWidth' => '7xl',
            'navLayout' => 'sidebar-collapsible',
            'sidebarWidth' => '20rem',
            'collapsedWidth' => '4.5rem',
            'radius' => 'md',
            'spacing' => 'comfortable',
            'font' => 'Inter',
            'fontSize' => 'md',
            'palette' => 'amber',
            'dark' => false,
        ];
    }

    public static function getResolvedSettings(string $panel = 'default', int|string|null $userId = null): array
    {
        $userId = $userId ?? auth()->id();

        // 1. Check user-specific settings if authenticated
        if ($userId) {
            $userSettings = static::getUserSettings($userId, $panel);
            if (! empty($userSettings)) {
                return array_merge(static::getDefaultSettings(), $userSettings);
            }
        }

        // 2. Check global system default settings
        $globalSettings = static::getGlobalSettings($panel);
        if (! empty($globalSettings)) {
            return array_merge(static::getDefaultSettings(), $globalSettings);
        }

        // 3. Fallback to factory defaults
        return static::getDefaultSettings();
    }

    public static function getUserSettings(int|string|null $userId, string $panel = 'default'): ?array
    {
        if (! $userId || ! static::hasTable()) {
            return null;
        }

        $cacheKey = "fi_theme_{$panel}_user_{$userId}";

        return Cache::rememberForever($cacheKey, function () use ($userId, $panel) {
            $record = ThemeSetting::where('user_id', $userId)
                ->where('panel', $panel)
                ->first();

            return $record?->settings;
        });
    }

    public static function getGlobalSettings(string $panel = 'default'): ?array
    {
        if (! static::hasTable()) {
            return null;
        }

        $cacheKey = "fi_theme_{$panel}_global";

        return Cache::rememberForever($cacheKey, function () use ($panel) {
            $record = ThemeSetting::whereNull('user_id')
                ->where('panel', $panel)
                ->first();

            return $record?->settings;
        });
    }

    public static function hasCustomUserSettings(string $panel = 'default', int|string|null $userId = null): bool
    {
        $userId = $userId ?? auth()->id();

        return static::getUserSettings($userId, $panel) !== null;
    }

    public static function saveUserSettings(array $settings, string $panel = 'default', int|string|null $userId = null): ThemeSetting
    {
        $userId = $userId ?? auth()->id();

        $record = ThemeSetting::updateOrCreate(
            ['user_id' => $userId, 'panel' => $panel],
            ['settings' => $settings]
        );

        Cache::forget("fi_theme_{$panel}_user_{$userId}");

        return $record;
    }

    public static function resetUserSettings(string $panel = 'default', int|string|null $userId = null): bool
    {
        $userId = $userId ?? auth()->id();

        if (! $userId) {
            return false;
        }

        $deleted = ThemeSetting::where('user_id', $userId)
            ->where('panel', $panel)
            ->delete();

        Cache::forget("fi_theme_{$panel}_user_{$userId}");

        return (bool) $deleted;
    }

    public static function saveGlobalSettings(array $settings, string $panel = 'default'): ThemeSetting
    {
        $record = ThemeSetting::updateOrCreate(
            ['user_id' => null, 'panel' => $panel],
            ['settings' => $settings]
        );

        Cache::forget("fi_theme_{$panel}_global");

        return $record;
    }

    protected static function hasTable(): bool
    {
        try {
            return Schema::hasTable('filament_theme_settings');
        } catch (\Throwable) {
            return false;
        }
    }
}
