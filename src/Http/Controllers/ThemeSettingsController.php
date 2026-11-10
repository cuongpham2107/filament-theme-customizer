<?php

namespace CuongPham\FilamentThemeCustomizer\Http\Controllers;

use CuongPham\FilamentThemeCustomizer\Services\ThemeSettingsService;
use CuongPham\FilamentThemeCustomizer\ThemeCustomizerPlugin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ThemeSettingsController extends Controller
{
    public function saveUserSettings(Request $request): JsonResponse
    {
        if (! auth()->check()) {
            return response()->json(['error' => __('filament-theme-customizer::messages.unauthenticated')], 401);
        }

        $plugin = ThemeCustomizerPlugin::get();
        if (! $plugin->isCustomizable()) {
            return response()->json(['error' => __('filament-theme-customizer::messages.unauthorized_customize')], 403);
        }

        $validated = $request->validate([
            'panel' => ['nullable', 'string', 'max:64'],
            'settings' => ['required', 'array'],
        ]);

        $panel = $validated['panel'] ?? 'default';
        $settings = $validated['settings'];

        ThemeSettingsService::saveUserSettings($settings, $panel, auth()->id());

        return response()->json([
            'success' => true,
            'message' => __('filament-theme-customizer::messages.user_saved'),
        ]);
    }

    public function resetUserSettings(Request $request): JsonResponse
    {
        if (! auth()->check()) {
            return response()->json(['error' => __('filament-theme-customizer::messages.unauthenticated')], 401);
        }

        $plugin = ThemeCustomizerPlugin::get();
        if (! $plugin->isCustomizable()) {
            return response()->json(['error' => __('filament-theme-customizer::messages.unauthorized_customize')], 403);
        }

        $panel = $request->input('panel', 'default');

        ThemeSettingsService::resetUserSettings($panel, auth()->id());
        $resolved = ThemeSettingsService::getResolvedSettings($panel, auth()->id());

        return response()->json([
            'success' => true,
            'message' => __('filament-theme-customizer::messages.user_reset'),
            'settings' => $resolved,
        ]);
    }

    public function saveGlobalDefault(Request $request): JsonResponse
    {
        if (! auth()->check()) {
            return response()->json(['error' => __('filament-theme-customizer::messages.unauthenticated')], 401);
        }

        $plugin = ThemeCustomizerPlugin::get();
        if (! $plugin->isGlobalDefaultAllowed()) {
            return response()->json(['error' => __('filament-theme-customizer::messages.unauthorized_global')], 403);
        }

        $validated = $request->validate([
            'panel' => ['nullable', 'string', 'max:64'],
            'settings' => ['required', 'array'],
        ]);

        $panel = $validated['panel'] ?? 'default';
        $settings = $validated['settings'];

        ThemeSettingsService::saveGlobalSettings($settings, $panel);

        return response()->json([
            'success' => true,
            'message' => __('filament-theme-customizer::messages.global_saved'),
        ]);
    }
}
