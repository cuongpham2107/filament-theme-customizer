# 🎨 Filament Theme Customizer (Theme Studio)

<p align="center">
  <a href="https://packagist.org/packages/cuongpham2107/filament-theme-customizer">
    <img src="https://img.shields.io/packagist/v/cuongpham2107/filament-theme-customizer.svg?style=flat-square" alt="Latest Version on Packagist">
  </a>
  <a href="https://packagist.org/packages/cuongpham2107/filament-theme-customizer">
    <img src="https://img.shields.io/packagist/dt/cuongpham2107/filament-theme-customizer.svg?style=flat-square" alt="Total Downloads">
  </a>
  <a href="LICENSE.md">
    <img src="https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square" alt="License: MIT">
  </a>
  <a href="https://filamentphp.com">
    <img src="https://img.shields.io/badge/Filament-v5.x-orange?style=flat-square&logo=laravel" alt="Filament Version">
  </a>
</p>

A powerful, elegant, **zero-reload** visual Theme Studio plugin for **Filament v5**. Empowers users and administrators to customize their panel experience in real time with instantaneous live preview, zero flash of unstyled theme (Anti-FOUC), and granular authorization controls.

---

<p align="center">
  <img src="art/hero-light.png" alt="Filament Theme Studio - Light Mode" width="100%">
</p>

<p align="center">
  <img src="art/hero-dark.png" alt="Filament Theme Studio - Obsidian Dark Mode" width="100%">
</p>

---

## 🖼️ Visual Showcase

| Light Mode (Palettes, Radius & Density) | Obsidian Dark Mode (Violet & Deep Blacks) |
|:---:|:---:|
| <img src="art/palette-swatches.png" alt="Color Palettes & Swatches" width="100%"> | <img src="art/dark-palette-swatches.png" alt="Dark Mode Swatches" width="100%"> |

| Velvet Theme (Warm & Soft Curves) | Precision Theme (Crisp Architectural Borders) |
|:---:|:---:|
| <img src="art/theme-velvet.png" alt="Velvet Linen Theme" width="100%"> | <img src="art/theme-precision.png" alt="Precision Sharp Theme" width="100%"> |

---

## ✨ Features

- ⚡ **Zero-Reload Instant Preview**: Hot-swaps themes, styles, colors, layouts, and typography in real time with zero page refresh.
- 🎨 **Official Theme Presets**: **Modern**, **Precision**, **Velvet**, and **Obsidian** (matching official Filament styling).
- 🌓 **Instant Dark / Light Mode**: Seamless transitions with full Tailwind dark mode compatibility.
- 🌈 **8 Curated Color Palettes**: Amber, Blue, Forest, Violet, Rose, Teal, Zinc, and Citrus with auto-contrasted primary button text.
- 🔲 **Live Corner Radius**: None (`0px`), Small (`4px`), Medium (`8px`), Large (`12px`), and Pill (`9999px`).
- 📐 **Live Spacing & Density**: Tight, Compact, Normal, and Spacious.
- 🔤 **Live Typography**: Inter, Outfit, Plus Jakarta Sans, Figtree, Lora, and JetBrains Mono.
- 📏 **Filament-Style Font Size Slider**: Sleek compact slider with discrete stops (`XS`, `SM`, `MD`, `LG`, `XL`) and signature handle.
- 🧭 **Navigation Layouts**:
  - Collapsible Sidebar
  - Fully Collapsible (Slide-over overlay with topbar toggle)
  - Fixed Sidebar
  - Top Navigation (Full-width topbar navbar)
- 🔒 **Flexible Authorization (`canCustomize`)**: Supports static booleans and dynamic `Closure` callbacks with dependency injection.
- 🛡️ **Anti-FOUC Engine**: Immediate inline DOM hydration from `localStorage` preventing any layout shift or theme flickering.

---

## 📦 Installation

Install the package via Composer:

```bash
composer require cuongpham2107/filament-theme-customizer
```

---

## 🚀 Quick Start

### 1. Register in your Filament Panel Provider

Add `ThemeCustomizerPlugin::make()` to your panel configuration (e.g. `app/Providers/Filament/AdminPanelProvider.php`):

```php
use CuongPham\FilamentThemeCustomizer\ThemeCustomizerPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(
            ThemeCustomizerPlugin::make()
                // Optional: button position ('bottom-right' or 'bottom-left', default: 'bottom-right')
                ->position('bottom-right')
                
                // Optional: access control (boolean or Closure evaluated at render time)
                ->canCustomize(fn (): bool => auth()->user()?->hasRole('super_admin') ?? true)
        );
}
```

### 2. Configure Tailwind Theme CSS

In your panel's theme stylesheet (e.g. `resources/css/filament/admin/theme.css`), import the plugin stylesheet and register the view files in your `@source` directive:

```css
@import '../../../../vendor/filament/filament/resources/css/theme.css';
@import '../../../../vendor/cuongpham2107/filament-theme-customizer/resources/css/theme-customizer.css';

@source '../../../../app/Filament/**/*';
@source '../../../../resources/views/filament/**/*';
@source '../../../../vendor/cuongpham2107/filament-theme-customizer/resources/views/**/*.blade.php';
```

Then rebuild your assets:

```bash
npm run build
```

---

## ⚙️ Configuration & Authorization

### Dynamic Permission Control

The `canCustomize()` method accepts either a boolean or a `Closure`:

```php
// Grant access only to Super Admins
ThemeCustomizerPlugin::make()
    ->canCustomize(fn (): bool => auth()->user()?->can('manage_theme') ?? false)

// Only enable in local development
ThemeCustomizerPlugin::make()
    ->canCustomize(app()->isLocal())

// Dependency injection in closure
ThemeCustomizerPlugin::make()
    ->canCustomize(function (?\App\Models\User $user): bool {
        return $user && $user->is_admin;
    })
```

---

## 🎨 Publishing Views (Optional)

If you want to customize the Blade templates:

```bash
php artisan vendor:publish --tag=filament-theme-customizer-views
```

The views will be published to `resources/views/vendor/filament-theme-customizer`.

---

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
