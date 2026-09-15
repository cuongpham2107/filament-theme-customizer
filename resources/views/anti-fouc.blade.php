@php
    $resolvedSettings = $resolvedSettings ?? [];
@endphp

<link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
<link href="https://fonts.bunny.net/css?family=lora:500,600,700|inter:400,500,600,700|outfit:400,500,600,700|plus-jakarta-sans:400,500,600,700|figtree:400,500,600,700|jetbrains-mono:400,500,600&display=swap" rel="stylesheet" />

<script>
    (function () {
        try {
            const server = @json($resolvedSettings);
            let raw = localStorage.getItem('fi_theme_customizer') || localStorage.getItem('fi_official_theme_studio');
            let local = null;
            try {
                local = raw ? JSON.parse(raw) : null;
            } catch (err) {
                local = null;
            }

            // Merge server settings (User or System Global) with any live local session
            const s = Object.assign({}, server || {}, local || {});
            if (!s || Object.keys(s).length === 0) return;

            const root = document.documentElement;

            let theme = s.theme || 'modern';
            if (theme === 'default') theme = 'modern';
            if (theme === 'sharp') theme = 'precision';
            if (theme === 'soft') theme = 'velvet';
            if (theme === 'noir') theme = 'obsidian';
            root.dataset.themeStyle = theme;

            if (s.surface) {
                root.dataset.surface = s.surface;
            }

            if (s.contentWidth) {
                root.dataset.contentWidth = s.contentWidth;
            }

            if (s.navLayout) {
                root.dataset.navLayout = s.navLayout;
                if (s.navLayout === 'sidebar-fully-collapsible') {
                    document.addEventListener('alpine:init', () => {
                        if (window.Alpine && window.Alpine.store('sidebar')) {
                            window.Alpine.store('sidebar').close();
                        }
                    }, { once: true });
                }
            }

            if (s.sidebarWidth) {
                root.dataset.sidebarWidth = s.sidebarWidth;
                root.style.setProperty('--sidebar-width', s.sidebarWidth);
            }

            if (s.collapsedWidth) {
                root.dataset.collapsedWidth = s.collapsedWidth;
                root.style.setProperty('--collapsed-sidebar-width', s.collapsedWidth);
            }

            if (s.spacing) {
                root.dataset.spacing = s.spacing;
                root.dataset.density = (s.spacing === 'tight' || s.spacing === 'compact') ? 'compact' : 'comfortable';
            } else if (s.compact !== undefined) {
                root.dataset.density = s.compact ? 'compact' : 'comfortable';
                root.dataset.spacing = s.compact ? 'compact' : 'comfortable';
            }

            if (s.radius) {
                root.dataset.radius = s.radius;
            }

            if (s.fontSize) {
                root.dataset.fontSize = s.fontSize;
            }

            if (s.font) {
                root.style.setProperty('--fi-font-family', `'${s.font}', system-ui, sans-serif`);
            }

            if (s.dark !== undefined) {
                root.classList.toggle('dark', Boolean(s.dark));
            } else if (theme === 'obsidian' || theme === 'noir') {
                root.classList.add('dark');
            }

            if (s.palette) {
                root.dataset.palette = s.palette;
                root.dataset.primaryBtnText = (s.palette === 'amber') ? 'dark' : 'white';
            }

            if (s.paletteColors && typeof s.paletteColors === 'object') {
                const isDarkText = (s.palette === 'amber');
                const btnTextColor = isDarkText ? '#451a03' : '#ffffff';
                const btnBg = isDarkText ? 'var(--primary-400)' : 'var(--primary-600)';
                const btnHoverBg = isDarkText ? 'var(--primary-300)' : 'var(--primary-500)';
                const btnDarkBg = isDarkText ? 'var(--primary-400)' : 'var(--primary-500)';
                const btnDarkHoverBg = isDarkText ? 'var(--primary-300)' : 'var(--primary-400)';

                let css = ':root {\n';
                for (const [shade, val] of Object.entries(s.paletteColors)) {
                    css += `  --primary-${shade}: ${val} !important;\n`;
                }
                css += `  --primary-btn-text: ${btnTextColor} !important;\n`;
                css += '}\n\n';

                css += `
.fi-btn.fi-color-primary:not(.fi-outlined) {
    --bg: ${btnBg} !important;
    --hover-bg: ${btnHoverBg} !important;
    --dark-bg: ${btnDarkBg} !important;
    --dark-hover-bg: ${btnDarkHoverBg} !important;
    --text: ${btnTextColor} !important;
    --hover-text: ${btnTextColor} !important;
    --dark-text: ${btnTextColor} !important;
    --dark-hover-text: ${btnTextColor} !important;
    background-color: ${btnBg} !important;
    color: ${btnTextColor} !important;
}
.fi-btn.fi-color-primary:not(.fi-outlined):hover {
    background-color: ${btnHoverBg} !important;
}
.dark .fi-btn.fi-color-primary:not(.fi-outlined) {
    background-color: ${btnDarkBg} !important;
    color: ${btnTextColor} !important;
}
.dark .fi-btn.fi-color-primary:not(.fi-outlined):hover {
    background-color: ${btnDarkHoverBg} !important;
}
.fi-btn.fi-color-primary:not(.fi-outlined) :is(.fi-btn-label, .fi-icon, svg) {
    color: ${btnTextColor} !important;
}
`;
                const styleEl = document.createElement('style');
                styleEl.id = 'fi-dynamic-palette-style';
                styleEl.textContent = css;
                document.head.appendChild(styleEl);
            }

            // Sync main content width class immediately on DOM ready
            document.addEventListener('DOMContentLoaded', () => {
                if (s.contentWidth) {
                    const main = document.getElementById('fi-main-content');
                    if (main && !main.classList.contains('fi-simple-main')) {
                        Array.from(main.classList).forEach(cls => {
                            if (cls.startsWith('fi-width-')) main.classList.remove(cls);
                        });
                        main.classList.add(`fi-width-${s.contentWidth}`);
                    }
                }
            });
        } catch (e) {}
    })();
</script>
