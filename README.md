# Filament Theme Customizer Plugin

A powerful, instant, zero-reload visual theme studio plugin for Filament v5.

## Features

- 🎨 **Instant Preset Switching**: Modern, Precision, Velvet, and Obsidian themes.
- 🌓 **Zero-Reload Dark/Light Mode**: Smooth instant transition.
- 🌈 **8 Tailored Color Palettes**: Amber, Blue, Forest, Violet, Rose, Teal, Zinc, Citrus.
- 🔲 **Live Corner Radius Adjustment**: None, Small, Medium, Large, Full.
- 📐 **Live Spacing & Density Control**: Tight, Compact, Normal, Spacious.
- 🔤 **Live Font Family**: Inter, Outfit, Plus Jakarta Sans, Figtree, Lora, JetBrains Mono.
- 📏 **Compact Filament Slider Font Sizing**: Seamless hot-swap font scaling (XS, SM, MD, LG, XL).
- 🧭 **Navigation Layouts**: Collapsible Sidebar, Fully Collapsible (Slide-over), Fixed, and Top Navigation.
- 🔒 **Authorization & Permission Control**: Support for closures and role/permission checks (`canCustomize`).
- ⚡ **Anti-FOUC Prevention**: Zero layout shift and zero flash of unstyled theme on page refresh.

## Installation

```bash
composer require cuongpham/filament-theme-customizer
```

## Registering in your Filament Panel

Add `ThemeCustomizerPlugin::make()` to your panel provider (e.g. `AdminPanelProvider.php`):

```php
use CuongPham\FilamentThemeCustomizer\ThemeCustomizerPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(
            ThemeCustomizerPlugin::make()
                // Optional: set custom position (default: 'bottom-right')
                ->position('bottom-right')
                // Optional: authorization condition (boolean or Closure)
                ->canCustomize(fn (): bool => auth()->user()?->hasRole('super_admin') ?? true)
        );
}
```

## Styling & Tailwind Integration

In your panel's theme CSS (e.g. `theme.css`), import the customizer stylesheet and include the package views in your `@source` directive:

```css
@import './path-to/packages/filament-theme-customizer/resources/css/theme-customizer.css';

@source './path-to/packages/filament-theme-customizer/resources/views/**/*.blade.php';
```

## Publishing Views

If you wish to customize the blade templates:

```bash
php artisan vendor:publish --tag=filament-theme-customizer-views
```

## License

MIT License.
