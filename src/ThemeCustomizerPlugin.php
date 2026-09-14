<?php

namespace CuongPham\FilamentThemeCustomizer;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class ThemeCustomizerPlugin implements Plugin
{
    protected bool | Closure $canCustomize = true;

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

    public function register(Panel $panel): void
    {
        if ($this->canCustomize === false) {
            return;
        }

        $panel->renderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => $this->isCustomizable()
                ? view("filament-theme-customizer::anti-fouc")->render()
                : "",
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
                ])->render()
                : "",
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
