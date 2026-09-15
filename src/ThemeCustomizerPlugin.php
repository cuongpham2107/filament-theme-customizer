<?php

namespace CuongPham\FilamentThemeCustomizer;

use Closure;
use CuongPham\FilamentThemeCustomizer\Services\ThemeSettingsService;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class ThemeCustomizerPlugin implements Plugin
{
    protected bool | Closure $canCustomize = true;

    protected bool | Closure $canSetGlobalDefault = false;

    protected string $position = "bottom-right";

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getId(): string
    {
        return "filament-theme-customizer";
    }

    public function position(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * Set the authorization condition to display and use the customizer.
     * Supports both a boolean flag and a Closure (evaluated at render time).
     */
    public function canCustomize(bool | Closure | null $condition = true): static
    {
        $this->canCustomize = $condition ?? true;

        return $this;
    }

    /**
     * Determine if customization is allowed for the current request / user.
     */
    public function isCustomizable(): bool
    {
        if ($this->canCustomize instanceof Closure) {
            return (bool) app()->call($this->canCustomize);
        }

        return (bool) $this->canCustomize;
    }

    /**
     * Set authorization condition allowing a Super Admin to save the current theme
     * as the system-wide default for all new users and unauthenticated sessions.
     */
    public function canSetGlobalDefault(bool | Closure | null $condition = true): static
    {
        $this->canSetGlobalDefault = $condition ?? true;

        return $this;
    }

    /**
     * Determine if setting the global default is allowed for current request / user.
     */
    public function isGlobalDefaultAllowed(): bool
    {
        if ($this->canSetGlobalDefault instanceof Closure) {
            return (bool) app()->call($this->canSetGlobalDefault);
        }

        return (bool) $this->canSetGlobalDefault;
    }

    public function register(Panel $panel): void
    {
        if ($this->canCustomize === false) {
            return;
        }

        $panelId = $panel->getId();

        // Always render anti-fouc in <head> using resolved theme (Global or User) to prevent flash
        $panel->renderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => view("filament-theme-customizer::anti-fouc", [
                "resolvedSettings" => ThemeSettingsService::getResolvedSettings($panelId),
            ])->render(),
        );

        $panel->renderHook(
            PanelsRenderHook::TOPBAR_LOGO_AFTER,
            fn (): string => $this->isCustomizable()
                ? view("filament-theme-customizer::top-navigation")->render()
                : "",
        );

        $panel->renderHook(
            PanelsRenderHook::BODY_END,
            fn (): string => $this->isCustomizable()
                ? view("filament-theme-customizer::toolbar", [
                    "position" => $this->position,
                    "panelId" => $panelId,
                    "resolvedSettings" => ThemeSettingsService::getResolvedSettings($panelId),
                    "hasCustomUserSettings" => ThemeSettingsService::hasCustomUserSettings($panelId),
                    "canSetGlobalDefault" => $this->isGlobalDefaultAllowed(),
                ])->render()
                : "",
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
