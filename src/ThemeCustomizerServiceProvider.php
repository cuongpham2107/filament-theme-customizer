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
            ->hasViews();
    }

    public function packageBooted(): void
    {
        //
    }
}
