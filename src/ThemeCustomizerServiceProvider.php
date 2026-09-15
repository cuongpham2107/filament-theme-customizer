<?php

namespace CuongPham\FilamentThemeCustomizer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ThemeCustomizerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-theme-customizer';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasMigration('2026_01_01_000000_create_filament_theme_settings_table');
    }

    public function packageBooted(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
