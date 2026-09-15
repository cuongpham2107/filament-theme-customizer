<?php

use CuongPham\FilamentThemeCustomizer\Http\Controllers\ThemeSettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->prefix('filament-theme-customizer')
    ->name('filament-theme-customizer.')
    ->group(function () {
        Route::post('save-user-settings', [ThemeSettingsController::class, 'saveUserSettings'])
            ->name('save-user-settings');

        Route::post('reset-user-settings', [ThemeSettingsController::class, 'resetUserSettings'])
            ->name('reset-user-settings');

        Route::post('save-global-default', [ThemeSettingsController::class, 'saveGlobalDefault'])
            ->name('save-global-default');
    });
