@php
    $palettesFile = resource_path('js/filament-palettes.json');
    $palettes = file_exists($palettesFile) ? json_decode(file_get_contents($palettesFile), true) : [];
    $panelId = $panelId ?? 'default';
    $resolvedSettings = $resolvedSettings ?? [];
    $hasCustomUserSettings = $hasCustomUserSettings ?? false;
    $canSetGlobalDefault = $canSetGlobalDefault ?? false;
@endphp

<div
    x-data="filamentThemeStudio({
        palettes: {{ Js::from($palettes) }},
        panelId: {{ Js::from($panelId) }},
        serverSettings: {{ Js::from($resolvedSettings) }},
        hasCustomUserSettings: {{ Js::from($hasCustomUserSettings) }},
        canSetGlobalDefault: {{ Js::from($canSetGlobalDefault) }},
        csrfToken: '{{ csrf_token() }}',
        routes: {
            saveUser: '{{ route('filament-theme-customizer.save-user-settings') }}',
            resetUser: '{{ route('filament-theme-customizer.reset-user-settings') }}',
            saveGlobal: '{{ route('filament-theme-customizer.save-global-default') }}',
        }
    })"
    x-cloak
    class="live-demo-toolbar"
>
    <!-- Floating Launcher Button -->
    <button
        @click="open = !open"
        type="button"
        class="live-demo-launcher"
        title="Customize Theme & Layout"
        aria-label="Customize Theme & Layout"
    >
        <span class="live-demo-launcher__label" aria-hidden="true">Theme Studio</span>
        <svg class="live-demo-launcher__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 0 0 5.304 0l6.401-6.402M6.75 21A3.75 3.75 0 0 1 3 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 0 0 3.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008Z" />
        </svg>
    </button>

    <!-- Studio Popover Drawer -->
    <section
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        class="live-demo-studio"
        aria-label="Theme Studio"
    >
        <!-- Header -->
        <header class="live-demo-studio__header">
            <div>
                <h2>Filament Theme Studio</h2>
                <p>Zero-reload instantaneous customization</p>
            </div>
            <button
                @click="open = false"
                type="button"
                class="live-demo-studio__close"
                aria-label="Close"
            >
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>
        </header>

        <!-- Body -->
        <div class="live-demo-studio__body">
            <!-- 1. Theme Presets (100% Free & Distinct Modern Themes) -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Theme Preset</span>
                    <span class="live-demo-studio__badge" x-text="getThemeLabel()"></span>
                </div>
                <div class="live-demo-studio__theme-grid">
                    <!-- Modern -->
                    <label class="live-demo-theme live-demo-theme--modern" :class="(theme === 'modern' || theme === 'default') ? 'is-active' : ''">
                        <input
                            type="radio"
                            name="live-demo-theme"
                            value="modern"
                            :checked="theme === 'modern' || theme === 'default'"
                            @change="setTheme('modern')"
                        />
                        <span class="live-demo-theme__name">Modern</span>
                        <span class="live-demo-theme__description">Clean & balanced</span>
                    </label>

                    <!-- Precision -->
                    <label class="live-demo-theme live-demo-theme--precision" :class="(theme === 'precision' || theme === 'sharp') ? 'is-active' : ''">
                        <input
                            type="radio"
                            name="live-demo-theme"
                            value="precision"
                            :checked="theme === 'precision' || theme === 'sharp'"
                            @change="setTheme('precision')"
                        />
                        <span class="live-demo-theme__name">Precision</span>
                        <span class="live-demo-theme__description">Crisp & architectural</span>
                    </label>

                    <!-- Velvet -->
                    <label class="live-demo-theme live-demo-theme--velvet" :class="(theme === 'velvet' || theme === 'soft') ? 'is-active' : ''">
                        <input
                            type="radio"
                            name="live-demo-theme"
                            value="velvet"
                            :checked="theme === 'velvet' || theme === 'soft'"
                            @change="setTheme('velvet')"
                        />
                        <span class="live-demo-theme__name">Velvet</span>
                        <span class="live-demo-theme__description">Warm & soft curves</span>
                    </label>

                    <!-- Obsidian -->
                    <label class="live-demo-theme live-demo-theme--obsidian" :class="(theme === 'obsidian' || theme === 'noir') ? 'is-active' : ''">
                        <input
                            type="radio"
                            name="live-demo-theme"
                            value="obsidian"
                            :checked="theme === 'obsidian' || theme === 'noir'"
                            @change="setTheme('obsidian')"
                        />
                        <span class="live-demo-theme__name">Obsidian</span>
                        <span class="live-demo-theme__description">High-contrast dark depth</span>
                    </label>
                </div>
            </fieldset>

            <!-- 2. Color Mode (Light / Dark) -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Color Mode</span>
                    <span class="live-demo-studio__badge" x-text="dark ? 'Dark' : 'Light'"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setDark(false)"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="!dark ? 'is-active' : ''"
                    >
                        <svg class="w-3.5 h-3.5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                        <span>Light</span>
                    </button>
                    <button
                        @click="setDark(true)"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="dark ? 'is-active' : ''"
                    >
                        <svg class="w-3.5 h-3.5 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                        <span>Dark</span>
                    </button>
                </div>
            </fieldset>

                        <!-- Navigation Layout (Zero-Reload) -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Navigation Layout</span>
                    <span class="live-demo-studio__badge" x-text="getNavLayoutLabel()"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setNavLayout('sidebar-collapsible')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="navLayout === 'sidebar-collapsible' ? 'is-active' : ''"
                        title="Collapsible on Desktop (Icons only)"
                    >
                        Collapsible
                    </button>
                    <button
                        @click="setNavLayout('sidebar-fully-collapsible')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="navLayout === 'sidebar-fully-collapsible' ? 'is-active' : ''"
                        title="Fully Collapsible (Slides offscreen)"
                    >
                        Slide
                    </button>
                    <button
                        @click="setNavLayout('sidebar-fixed')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="navLayout === 'sidebar-fixed' ? 'is-active' : ''"
                        title="Fixed Expanded Sidebar"
                    >
                        Fixed
                    </button>
                    <button
                        @click="setNavLayout('top')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="navLayout === 'top' ? 'is-active' : ''"
                        title="Top Navigation Bar (Horizontal)"
                    >
                        Top Nav
                    </button>
                </div>
            </fieldset>

            <!-- Sidebar Width (Độ rộng khi hiển thị) -->
            <fieldset x-show="navLayout !== 'top'">
                <div class="live-demo-studio__label">
                    <span>Sidebar Width</span>
                    <span class="live-demo-studio__badge" x-text="sidebarWidth"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setSidebarWidth('16rem')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="sidebarWidth === '16rem' ? 'is-active' : ''"
                        title="Slim (16rem / 256px)"
                    >
                        16rem
                    </button>
                    <button
                        @click="setSidebarWidth('18rem')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="sidebarWidth === '18rem' ? 'is-active' : ''"
                        title="Compact (18rem / 288px)"
                    >
                        18rem
                    </button>
                    <button
                        @click="setSidebarWidth('20rem')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="sidebarWidth === '20rem' ? 'is-active' : ''"
                        title="Default (20rem / 320px)"
                    >
                        20rem
                    </button>
                    <button
                        @click="setSidebarWidth('22rem')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="sidebarWidth === '22rem' ? 'is-active' : ''"
                        title="Wide (22rem / 352px)"
                    >
                        22rem
                    </button>
                    <button
                        @click="setSidebarWidth('24rem')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="sidebarWidth === '24rem' ? 'is-active' : ''"
                        title="Comfortable (24rem / 384px)"
                    >
                        24rem
                    </button>
                </div>
            </fieldset>

            <!-- 3. Maximum Content Width (Zero-Reload) -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Content Width</span>
                    <span class="live-demo-studio__badge" x-text="getWidthLabel()"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setContentWidth('full')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="contentWidth === 'full' ? 'is-active' : ''"
                        title="100% Full Width (Edge to Edge)"
                    >
                        Full
                    </button>
                    <button
                        @click="setContentWidth('screen-2xl')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="contentWidth === 'screen-2xl' ? 'is-active' : ''"
                        title="Ultrawide 1536px (Screen 2XL)"
                    >
                        2XL
                    </button>
                    <button
                        @click="setContentWidth('7xl')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="contentWidth === '7xl' ? 'is-active' : ''"
                        title="Default 1280px (7XL)"
                    >
                        7XL
                    </button>
                    <button
                        @click="setContentWidth('6xl')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="contentWidth === '6xl' ? 'is-active' : ''"
                        title="1152px (6XL)"
                    >
                        6XL
                    </button>
                    <button
                        @click="setContentWidth('5xl')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="contentWidth === '5xl' ? 'is-active' : ''"
                        title="1024px (5XL)"
                    >
                        5XL
                    </button>
                </div>
                <!-- Custom Scale Dropdown (All Filament Width Enums) -->
                <div class="mt-1.5 flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400">
                    <span>Tailwind scale:</span>
                    <select
                        :value="contentWidth"
                        @change="setContentWidth($event.target.value)"
                        class="text-[11px] py-0.5 px-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500 cursor-pointer"
                    >
                        <optgroup label="Full & Screen Scale">
                            <option value="full">Full (100% Edge-to-Edge)</option>
                            <option value="screen-2xl">Screen 2XL (1536px)</option>
                            <option value="screen-xl">Screen XL (1280px)</option>
                            <option value="screen-lg">Screen LG (1024px)</option>
                            <option value="screen-md">Screen MD (768px)</option>
                            <option value="screen-sm">Screen SM (640px)</option>
                        </optgroup>
                        <optgroup label="Standard Max-Width Scale">
                            <option value="7xl">7XL (1280px - Default)</option>
                            <option value="6xl">6XL (1152px)</option>
                            <option value="5xl">5XL (1024px)</option>
                            <option value="4xl">4XL (896px)</option>
                            <option value="3xl">3XL (768px)</option>
                            <option value="2xl">2XL (672px)</option>
                            <option value="xl">XL (576px)</option>
                            <option value="lg">LG (512px)</option>
                            <option value="md">MD (448px)</option>
                            <option value="sm">SM (384px)</option>
                            <option value="xs">XS (320px)</option>
                            <option value="2xs">2XS (288px)</option>
                            <option value="3xs">3XS (256px)</option>
                        </optgroup>
                        <optgroup label="Content Scale">
                            <option value="prose">Prose (65ch text)</option>
                            <option value="fit">Fit Content</option>
                            <option value="max">Max Content</option>
                            <option value="min">Min Content</option>
                        </optgroup>
                    </select>
                </div>
            </fieldset>

            <!-- 4. Background Surface -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Background Surface</span>
                    <span class="live-demo-studio__badge" x-text="getSurfaceLabel()"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setSurface('default')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="surface === 'default' ? 'is-active' : ''"
                    >
                        Default
                    </button>
                    <button
                        @click="setSurface('linen')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="surface === 'linen' ? 'is-active' : ''"
                    >
                        Linen
                    </button>
                    <button
                        @click="setSurface('slate')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="surface === 'slate' ? 'is-active' : ''"
                    >
                        Slate
                    </button>
                    <button
                        @click="setSurface('stone')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="surface === 'stone' ? 'is-active' : ''"
                    >
                        Stone
                    </button>
                    <button
                        @click="setSurface('pure')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="surface === 'pure' ? 'is-active' : ''"
                    >
                        Pure
                    </button>
                </div>
            </fieldset>

            <!-- 5. Primary Color Swatches -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Primary Color</span>
                    <span class="live-demo-studio__badge flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full inline-block shadow-xs" :style="'background-color: var(--primary-500, #f59e0b);'"></span>
                        <span x-text="getPaletteLabel()"></span>
                    </span>
                </div>
                <div class="live-demo-palettes">
                    <button
                        @click="setPalette('amber')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'amber' ? 'is-active' : ''"
                        style="background-color: #f59e0b;"
                        title="Amber"
                    ></button>
                    <button
                        @click="setPalette('blue')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'blue' ? 'is-active' : ''"
                        style="background-color: #3b82f6;"
                        title="Blue"
                    ></button>
                    <button
                        @click="setPalette('forest')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'forest' ? 'is-active' : ''"
                        style="background-color: #10b981;"
                        title="Forest Green"
                    ></button>
                    <button
                        @click="setPalette('citrus')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'citrus' ? 'is-active' : ''"
                        style="background-color: #f97316;"
                        title="Citrus Orange"
                    ></button>
                    <button
                        @click="setPalette('violet')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'violet' ? 'is-active' : ''"
                        style="background-color: #8b5cf6;"
                        title="Violet"
                    ></button>
                    <button
                        @click="setPalette('rose')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'rose' ? 'is-active' : ''"
                        style="background-color: #f43f5e;"
                        title="Rose"
                    ></button>
                    <button
                        @click="setPalette('teal')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'teal' ? 'is-active' : ''"
                        style="background-color: #14b8a6;"
                        title="Teal"
                    ></button>
                    <button
                        @click="setPalette('zinc')"
                        type="button"
                        class="live-demo-palette-btn"
                        :class="palette === 'zinc' ? 'is-active' : ''"
                        style="background-color: #71717a;"
                        title="Zinc"
                    ></button>
                </div>
            </fieldset>

            <!-- 6. Border Radius -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Border Radius</span>
                    <span class="live-demo-studio__badge" x-text="getRadiusLabel()"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setRadius('0')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="radius === '0' ? 'is-active' : ''"
                    >
                        0
                    </button>
                    <button
                        @click="setRadius('sm')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="radius === 'sm' ? 'is-active' : ''"
                    >
                        Sm
                    </button>
                    <button
                        @click="setRadius('md')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="radius === 'md' ? 'is-active' : ''"
                    >
                        Md
                    </button>
                    <button
                        @click="setRadius('lg')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="radius === 'lg' ? 'is-active' : ''"
                    >
                        Lg
                    </button>
                    <button
                        @click="setRadius('xl')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="radius === 'xl' ? 'is-active' : ''"
                    >
                        Xl
                    </button>
                    <button
                        @click="setRadius('full')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="radius === 'full' ? 'is-active' : ''"
                    >
                        Pill
                    </button>
                </div>
            </fieldset>

            <!-- 7. Spacing / Density (Compact controls) -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Spacing & Density</span>
                    <span class="live-demo-studio__badge" x-text="getSpacingLabel()"></span>
                </div>
                <div class="live-demo-segmented">
                    <button
                        @click="setSpacing('tight')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="spacing === 'tight' ? 'is-active' : ''"
                        title="Ultra-compact tables and forms"
                    >
                        Tight
                    </button>
                    <button
                        @click="setSpacing('compact')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="spacing === 'compact' ? 'is-active' : ''"
                        title="Compact desktop view ($29 USD)"
                    >
                        Compact
                    </button>
                    <button
                        @click="setSpacing('comfortable')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="spacing === 'comfortable' ? 'is-active' : ''"
                        title="Standard comfortable spacing"
                    >
                        Normal
                    </button>
                    <button
                        @click="setSpacing('spacious')"
                        type="button"
                        class="live-demo-segmented-item"
                        :class="spacing === 'spacious' ? 'is-active' : ''"
                        title="Airy and relaxed spacing"
                    >
                        Spacious
                    </button>
                </div>
            </fieldset>

            <!-- 8. Font Family -->
            <fieldset>
                <div class="live-demo-studio__label">
                    <span>Font Family</span>
                    <span class="live-demo-studio__badge" x-text="font"></span>
                </div>
                <div class="live-demo-font-grid">
                    <button
                        @click="setFont('Inter')"
                        type="button"
                        class="live-demo-font-item"
                        :class="font === 'Inter' ? 'is-active' : ''"
                        style="font-family: 'Inter', sans-serif;"
                    >
                        Inter
                    </button>
                    <button
                        @click="setFont('Outfit')"
                        type="button"
                        class="live-demo-font-item"
                        :class="font === 'Outfit' ? 'is-active' : ''"
                        style="font-family: 'Outfit', sans-serif;"
                    >
                        Outfit
                    </button>
                    <button
                        @click="setFont('Plus Jakarta Sans')"
                        type="button"
                        class="live-demo-font-item"
                        :class="font === 'Plus Jakarta Sans' ? 'is-active' : ''"
                        style="font-family: 'Plus Jakarta Sans', sans-serif;"
                    >
                        Jakarta
                    </button>
                    <button
                        @click="setFont('Figtree')"
                        type="button"
                        class="live-demo-font-item"
                        :class="font === 'Figtree' ? 'is-active' : ''"
                        style="font-family: 'Figtree', sans-serif;"
                    >
                        Figtree
                    </button>
                    <button
                        @click="setFont('Lora')"
                        type="button"
                        class="live-demo-font-item"
                        :class="font === 'Lora' ? 'is-active' : ''"
                        style="font-family: 'Lora', Georgia, serif;"
                    >
                        Lora
                    </button>
                    <button
                        @click="setFont('JetBrains Mono')"
                        type="button"
                        class="live-demo-font-item"
                        :class="font === 'JetBrains Mono' ? 'is-active' : ''"
                        style="font-family: 'JetBrains Mono', monospace;"
                    >
                        Mono
                    </button>
                </div>
            </fieldset>

            <!-- 9. Font Size Scale (Compact Filament-Style Slider) -->
            <fieldset class="space-y-2">
                <div class="live-demo-studio__label">
                    <span>Font Size</span>
                    <span class="live-demo-studio__badge" x-text="getFontSizeLabel()"></span>
                </div>
                
                <div class="px-2 pt-1 pb-1">
                    <div 
                        class="filament-custom-slider select-none"
                        x-data="{
                            get percent() {
                                return getFontSizePercent();
                            },
                            steps: [
                                { val: 0, label: 'XS' },
                                { val: 25, label: 'SM' },
                                { val: 50, label: 'MD' },
                                { val: 75, label: 'LG' },
                                { val: 100, label: 'XL' }
                            ]
                        }"
                    >
                        <!-- Track & Handle Layer -->
                        <div class="relative w-full h-[18px] flex items-center">
                            <!-- Track Background -->
                            <div class="w-full h-[8px] rounded-full bg-gray-950/5 dark:bg-white/5 border border-gray-950/10 dark:border-white/10 overflow-hidden relative shadow-inner">
                                <!-- Connect (Fill Track) -->
                                <div 
                                    class="h-full rounded-full bg-primary-500/30 dark:bg-primary-500/40 transition-all duration-75"
                                    :style="`width: ${percent}%;`"
                                ></div>
                            </div>

                            <!-- Filament Signature Handle: Compact 22px x 18px with || grab bars -->
                            <div 
                                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-[22px] h-[18px] rounded-md bg-white dark:bg-gray-700 border border-gray-950/15 dark:border-white/20 shadow-sm flex items-center justify-center gap-[2.5px] pointer-events-none transition-all duration-75 ring-1 ring-black/5 dark:ring-white/5"
                                :style="`left: ${percent}%;`"
                            >
                                <span class="w-[1px] h-[9px] bg-gray-400 dark:bg-gray-400 rounded-full"></span>
                                <span class="w-[1px] h-[9px] bg-gray-400 dark:bg-gray-400 rounded-full"></span>
                            </div>

                            <!-- Invisible Native Range Input for native drag, click, touch, & keyboard control -->
                            <input 
                                type="range"
                                min="0"
                                max="100"
                                step="25"
                                :value="percent"
                                @input="setFontSizeFromPercent($event.target.value)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                aria-label="Font Size Slider"
                            />
                        </div>

                        <!-- Pips (Ticks & Labels matching Filament docs) -->
                        <div class="relative w-full h-5 mt-1.5">
                            <template x-for="step in steps" :key="step.val">
                                <div 
                                    class="absolute -translate-x-1/2 flex flex-col items-center cursor-pointer group"
                                    :style="`left: ${step.val}%;`"
                                    @click="setFontSizeFromPercent(step.val)"
                                >
                                    <!-- Tick | -->
                                    <span 
                                        class="w-[1px] h-[4px] transition-colors"
                                        :class="percent === step.val ? 'bg-primary-600 dark:bg-primary-400 font-bold' : 'bg-gray-300 dark:bg-gray-600 group-hover:bg-gray-400'"
                                    ></span>
                                    
                                    <!-- Value Label -->
                                    <span 
                                        class="mt-0.5 text-[10px] font-medium transition-colors"
                                        :class="percent === step.val ? 'text-primary-600 dark:text-primary-400 font-semibold' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200'"
                                        x-text="step.label"
                                    ></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- 10. Cloud Sync & Persistence -->
            <fieldset class="live-demo-studio__persistence">
                <div class="live-demo-studio__label">
                    <span>Lưu & Đồng bộ</span>
                    <span
                        class="live-demo-studio__badge"
                        :class="hasUserOverride ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' : ''"
                        x-text="hasUserOverride ? 'Đã cá nhân hóa' : 'Theo mặc định'"
                    ></span>
                </div>

                <div class="flex flex-col gap-2 mt-2">
                    <!-- Save for current user -->
                    <button
                        @click="saveUserSettings()"
                        type="button"
                        :disabled="isSaving"
                        class="live-demo-btn-save live-demo-btn-user"
                    >
                        <template x-if="isSaving">
                            <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!isSaving">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                            </svg>
                        </template>
                        <span x-text="isSaving ? 'Đang lưu vào tài khoản...' : '💾 Lưu cấu hình của tôi'"></span>
                    </button>

                    <!-- Reset to system default button (shown if user has custom settings) -->
                    <button
                        x-show="hasUserOverride"
                        @click="resetUserSettings()"
                        type="button"
                        :disabled="isResetting"
                        class="live-demo-btn-save live-demo-btn-reset"
                    >
                        <span x-text="isResetting ? 'Đang khôi phục...' : '↺ Về mặc định hệ thống'"></span>
                    </button>

                    <!-- Super Admin Action -->
                    @if ($canSetGlobalDefault)
                        <div class="mt-2 pt-2 border-t border-dashed border-gray-200 dark:border-gray-800">
                            <button
                                @click="saveGlobalDefault()"
                                type="button"
                                :disabled="isSavingGlobal"
                                class="live-demo-btn-save live-demo-btn-global"
                                title="Lưu giao diện này làm mặc định cho toàn bộ khách và mọi người dùng mới"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                                <span x-text="isSavingGlobal ? 'Đang lưu mặc định...' : '⭐ Đặt làm mặc định toàn hệ thống'"></span>
                            </button>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 text-center">Áp dụng cho trang đăng nhập & mọi user mới</p>
                        </div>
                    @endif

                    <!-- Notification Feedback Alert -->
                    <div
                        x-show="notification.show"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="live-demo-notification-box"
                        :class="notification.type === 'success' ? 'is-success' : 'is-error'"
                        x-text="notification.message"
                    ></div>
                </div>
            </fieldset>

            <!-- 11. Reset & Info -->
            <div class="flex items-center justify-between pt-1 border-t border-gray-200 dark:border-gray-800">
                <button
                    @click="reset()"
                    type="button"
                    class="text-xs text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition"
                >
                    Reset all default
                </button>
                <span class="text-[11px] font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Free Plugin</span>
                </span>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('filamentThemeStudio', ({
            palettes = {},
            panelId = 'default',
            serverSettings = {},
            hasCustomUserSettings = false,
            canSetGlobalDefault = false,
            csrfToken = '',
            routes = {}
        } = {}) => ({
            open: false,
            panelId: panelId,
            serverSettings: serverSettings,
            hasUserOverride: Boolean(hasCustomUserSettings),
            canSetGlobalDefault: Boolean(canSetGlobalDefault),
            csrfToken: csrfToken,
            routes: routes,
            isSaving: false,
            isResetting: false,
            isSavingGlobal: false,
            notification: { show: false, message: '', type: 'success' },

            theme: 'modern',
            navLayout: 'sidebar-collapsible',
            sidebarWidth: '20rem',
            collapsedWidth: '4.5rem',
            surface: 'default',
            contentWidth: '7xl',
            dark: false,
            palette: 'amber',
            radius: 'md',
            spacing: 'comfortable',
            font: 'Inter',
            fontSize: 'md',
            palettes: palettes,

            
            getThemeLabel() {
                const map = {
                    modern: 'Modern',
                    default: 'Modern',
                    precision: 'Precision',
                    sharp: 'Precision',
                    velvet: 'Velvet',
                    soft: 'Velvet',
                    obsidian: 'Obsidian',
                    noir: 'Obsidian',
                };
                return map[this.theme] || this.theme;
            },

            getWidthLabel() {
                const map = {
                    full: 'Full (100%)',
                    'screen-2xl': '2XL (1536px)',
                    '7xl': '7XL (1280px)',
                    '6xl': '6XL (1152px)',
                    '5xl': '5XL (1024px)',
                    '4xl': '4XL (896px)',
                    '3xl': '3XL (768px)',
                    '2xl': '2XL (672px)',
                    xl: 'XL (576px)',
                    lg: 'LG (512px)',
                    md: 'MD (448px)',
                    sm: 'SM (384px)',
                    xs: 'XS (320px)',
                    prose: 'Prose',
                };
                return map[this.contentWidth] || this.contentWidth.toUpperCase();
            },

            getSurfaceLabel() {
                const map = {
                    default: 'Default',
                    linen: 'Linen',
                    slate: 'Slate',
                    stone: 'Stone',
                    pure: 'Pure',
                };
                return map[this.surface] || this.surface;
            },

            getPaletteLabel() {
                const map = {
                    amber: 'Amber',
                    blue: 'Blue',
                    emerald: 'Forest Green',
                    orange: 'Citrus Orange',
                    purple: 'Violet',
                    rose: 'Rose',
                    teal: 'Teal',
                    zinc: 'Zinc',
                };
                return map[this.palette] || this.palette;
            },

            getRadiusLabel() {
                const map = {
                    '0': '0px (Sharp)',
                    sm: 'Sm (4px)',
                    md: 'Md (8px)',
                    lg: 'Lg (12px)',
                    xl: 'Xl (16px)',
                    full: 'Pill',
                };
                return map[this.radius] || this.radius;
            },

            getSpacingLabel() {
                const map = {
                    tight: 'Tight',
                    compact: 'Compact',
                    comfortable: 'Normal',
                    spacious: 'Spacious',
                };
                return map[this.spacing] || this.spacing;
            },

            getFontSizeLabel() {
                const map = {
                    xs: '12px (XS)',
                    sm: '13px (SM)',
                    md: '14px (MD)',
                    lg: '15.5px (LG)',
                    xl: '17px (XL)',
                };
                return map[this.fontSize] || this.fontSize;
            },

            getFontSizePercent() {
                const map = {
                    xs: 0,
                    sm: 25,
                    md: 50,
                    lg: 75,
                    xl: 100,
                };
                return map[this.fontSize] ?? 50;
            },

            setFontSizeFromPercent(val) {
                const num = Math.round(Number(val));
                let size = 'md';
                if (num <= 12) size = 'xs';
                else if (num <= 37) size = 'sm';
                else if (num <= 62) size = 'md';
                else if (num <= 87) size = 'lg';
                else size = 'xl';

                if (this.fontSize !== size) {
                    this.setFontSize(size);
                }
            },

            notify(msg, type = 'success') {
                this.notification = { show: true, message: msg, type: type };
                setTimeout(() => {
                    this.notification.show = false;
                }, 4000);
            },

            collectSettings() {
                return {
                    theme: this.theme,
                    surface: this.surface,
                    contentWidth: this.contentWidth,
                    navLayout: this.navLayout,
                    sidebarWidth: this.sidebarWidth,
                    collapsedWidth: this.collapsedWidth,
                    radius: this.radius,
                    spacing: this.spacing,
                    font: this.font,
                    fontSize: this.fontSize,
                    palette: this.palette,
                    paletteColors: this.palettes[this.palette] || null,
                    dark: this.dark,
                };
            },

            applySettingsObject(s) {
                if (!s || typeof s !== 'object') return;
                if (s.theme) this.theme = s.theme;
                if (s.surface) this.surface = s.surface;
                if (s.contentWidth) this.contentWidth = s.contentWidth;
                if (s.navLayout) this.navLayout = s.navLayout;
                if (s.sidebarWidth) this.sidebarWidth = s.sidebarWidth;
                if (s.collapsedWidth) this.collapsedWidth = s.collapsedWidth;
                if (s.radius) this.radius = s.radius;
                if (s.spacing) this.spacing = s.spacing;
                if (s.font) this.font = s.font;
                if (s.fontSize) this.fontSize = s.fontSize;
                if (s.palette) this.palette = s.palette;
                if (s.dark !== undefined) this.dark = Boolean(s.dark);
                this.applyTheme();
                this.saveSettings();
            },

            async saveUserSettings() {
                this.isSaving = true;
                try {
                    const res = await fetch(this.routes.saveUser, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            panel: this.panelId,
                            settings: this.collectSettings()
                        })
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.hasUserOverride = true;
                        this.notify(data.message || '✓ Đã lưu cấu hình cá nhân của bạn!', 'success');
                    } else {
                        this.notify(data.error || 'Lỗi khi lưu cấu hình.', 'error');
                    }
                } catch (e) {
                    this.notify('Lỗi kết nối máy chủ.', 'error');
                } finally {
                    this.isSaving = false;
                }
            },

            async resetUserSettings() {
                this.isResetting = true;
                try {
                    const res = await fetch(this.routes.resetUser, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ panel: this.panelId })
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.hasUserOverride = false;
                        if (data.settings) {
                            this.applySettingsObject(data.settings);
                        } else {
                            this.reset();
                        }
                        this.notify(data.message || '✓ Đã khôi phục về mặc định hệ thống!', 'success');
                    } else {
                        this.notify(data.error || 'Lỗi khi khôi phục.', 'error');
                    }
                } catch (e) {
                    this.notify('Lỗi kết nối máy chủ.', 'error');
                } finally {
                    this.isResetting = false;
                }
            },

            async saveGlobalDefault() {
                if (!confirm('Bạn có chắc muốn đặt giao diện hiện tại làm MẶC ĐỊNH cho toàn bộ hệ thống & người dùng mới?')) {
                    return;
                }
                this.isSavingGlobal = true;
                try {
                    const res = await fetch(this.routes.saveGlobal, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            panel: this.panelId,
                            settings: this.collectSettings()
                        })
                    });
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.notify(data.message || '⭐ Đã lưu làm mặc định toàn hệ thống!', 'success');
                    } else {
                        this.notify(data.error || 'Lỗi khi lưu mặc định toàn hệ thống.', 'error');
                    }
                } catch (e) {
                    this.notify('Lỗi kết nối máy chủ.', 'error');
                } finally {
                    this.isSavingGlobal = false;
                }
            },

            init() {
                this.loadSettings();

                document.addEventListener('livewire:navigated', () => {
                    this.applyTheme();
                });
            },

            loadSettings() {
                try {
                    const raw = localStorage.getItem('fi_theme_customizer') || localStorage.getItem('fi_official_theme_studio');
                    let parsed = null;
                    if (raw) {
                        try { parsed = JSON.parse(raw); } catch (e) {}
                    }
                    const s = Object.assign({}, this.serverSettings || {}, parsed || {});
                    if (s) {
                        if (s.theme) {
                            let t = s.theme;
                            if (t === 'default') t = 'modern';
                            if (t === 'sharp') t = 'precision';
                            if (t === 'soft') t = 'velvet';
                            if (t === 'noir') t = 'obsidian';
                            this.theme = t;
                        }
                        if (s.surface) this.surface = s.surface;
                        if (s.contentWidth) this.contentWidth = s.contentWidth;
                        if (s.navLayout) this.navLayout = s.navLayout;
                        if (s.sidebarWidth) this.sidebarWidth = s.sidebarWidth;
                        if (s.collapsedWidth) this.collapsedWidth = s.collapsedWidth;
                        if (s.palette) this.palette = s.palette;
                        if (s.radius) this.radius = s.radius;
                        if (s.font) this.font = s.font;
                        if (s.fontSize) this.fontSize = s.fontSize;
                        if (s.spacing) this.spacing = s.spacing;
                        else if (s.compact) this.spacing = 'compact';
                        if (s.dark !== undefined) {
                            this.dark = Boolean(s.dark);
                        } else {
                            this.dark = localStorage.getItem('theme') === 'dark' || document.documentElement.classList.contains('dark');
                        }
                    }
                } catch (e) {}

                if (window.Alpine && window.Alpine.store('sidebar')) {
                    if (this.navLayout === 'sidebar-fully-collapsible') {
                        window.Alpine.store('sidebar').close();
                    }
                }

                this.applyTheme();
            },

            saveSettings() {
                localStorage.setItem('fi_theme_customizer', JSON.stringify({
                    theme: this.theme,
                    surface: this.surface,
                    contentWidth: this.contentWidth,
                    navLayout: this.navLayout,
                    sidebarWidth: this.sidebarWidth,
                    collapsedWidth: this.collapsedWidth,
                    dark: this.dark,
                    palette: this.palette,
                    radius: this.radius,
                    font: this.font,
                    fontSize: this.fontSize,
                    spacing: this.spacing,
                    paletteColors: this.palettes[this.palette] || null,
                }));
            },

            applyTheme() {
                const root = document.documentElement;

                root.dataset.themeStyle = this.theme;
                root.dataset.surface = this.surface;
                root.dataset.contentWidth = this.contentWidth;
                root.dataset.navLayout = this.navLayout;
                root.dataset.sidebarWidth = this.sidebarWidth;
                root.style.setProperty('--sidebar-width', this.sidebarWidth);
                root.dataset.collapsedWidth = this.collapsedWidth;
                root.style.setProperty('--collapsed-sidebar-width', this.collapsedWidth);
                root.dataset.radius = this.radius;
                root.dataset.spacing = this.spacing;
                root.dataset.density = (this.spacing === 'tight' || this.spacing === 'compact') ? 'compact' : 'comfortable';
                root.dataset.fontSize = this.fontSize;

                // Sync main container width class in real-time (exclude login / simple layout)
                const main = document.getElementById('fi-main-content');
                if (main && !main.classList.contains('fi-simple-main')) {
                    Array.from(main.classList).forEach(cls => {
                        if (cls.startsWith('fi-width-')) main.classList.remove(cls);
                    });
                    main.classList.add(`fi-width-${this.contentWidth}`);
                }

                if (this.font) {
                    root.style.setProperty('--fi-font-family', `'${this.font}', system-ui, sans-serif`);
                }

// Obsidian now supports both Light and Dark mode natively

                this.applyPaletteToDOM();
            },

                        setNavLayout(layout) {
                this.navLayout = layout;
                if (window.Alpine && window.Alpine.store('sidebar')) {
                    if (layout === 'sidebar-fully-collapsible') {
                        window.Alpine.store('sidebar').close();
                    } else if (layout === 'sidebar-fixed' || layout === 'sidebar-collapsible') {
                        window.Alpine.store('sidebar').open();
                    }
                }
                this.applyTheme();
                this.saveSettings();
            },

            setSidebarWidth(w) {
                this.sidebarWidth = w;
                this.applyTheme();
                this.saveSettings();
            },

            setCollapsedWidth(w) {
                this.collapsedWidth = w;
                this.applyTheme();
                this.saveSettings();
            },

            getNavLayoutLabel() {
                const map = {
                    'sidebar-collapsible': 'Collapsible',
                    'sidebar-fully-collapsible': 'Full Slide',
                    'sidebar-fixed': 'Fixed',
                    'top': 'Top Nav',
                };
                return map[this.navLayout] || this.navLayout;
            },

            setTheme(t) {
                this.theme = t;
                if (t === 'obsidian' || t === 'noir') {
                    this.setDark(true);
                    this.surface = 'default';
                    this.radius = 'sm';
                } else if (t === 'velvet' || t === 'soft') {
                    this.surface = 'linen';
                    this.radius = 'full';
                } else if (t === 'precision' || t === 'sharp') {
                    this.radius = '0';
                    this.surface = 'default';
                } else if (t === 'modern' || t === 'default') {
                    this.radius = 'md';
                    this.surface = 'default';
                }
                this.applyTheme();
                this.saveSettings();
            },

            setContentWidth(w) {
                this.contentWidth = w;
                this.applyTheme();
                this.saveSettings();
            },

            setSurface(s) {
                this.surface = s;
                this.applyTheme();
                this.saveSettings();
            },

            setRadius(r) {
                this.radius = r;
                this.applyTheme();
                this.saveSettings();
            },

            setSpacing(s) {
                this.spacing = s;
                this.applyTheme();
                this.saveSettings();
            },

            setFont(f) {
                this.font = f;
                this.applyTheme();
                this.saveSettings();
            },

            setFontSize(fs) {
                this.fontSize = fs;
                this.applyTheme();
                this.saveSettings();
            },

            setPalette(p) {
                this.palette = p;
                this.applyPaletteToDOM();
                this.saveSettings();
            },

            setDark(isDark) {
                this.dark = isDark;
                const scheme = isDark ? 'dark' : 'light';
                localStorage.setItem('theme', scheme);
                document.documentElement.classList.toggle('dark', isDark);
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: scheme }));
                this.saveSettings();
            },

            applyPaletteToDOM() {
                const root = document.documentElement;
                root.dataset.palette = this.palette;

                const isDarkText = (this.palette === 'amber');
                root.dataset.primaryBtnText = isDarkText ? 'dark' : 'white';

                const colors = this.palettes[this.palette];
                if (!colors) return;

                let styleEl = document.getElementById('fi-dynamic-palette-style');
                if (!styleEl) {
                    styleEl = document.createElement('style');
                    styleEl.id = 'fi-dynamic-palette-style';
                    document.head.appendChild(styleEl);
                }

                const btnTextColor = isDarkText ? '#451a03' : '#ffffff';
                const btnBg = isDarkText ? 'var(--primary-400)' : 'var(--primary-600)';
                const btnHoverBg = isDarkText ? 'var(--primary-300)' : 'var(--primary-500)';
                const btnDarkBg = isDarkText ? 'var(--primary-400)' : 'var(--primary-500)';
                const btnDarkHoverBg = isDarkText ? 'var(--primary-300)' : 'var(--primary-400)';

                let css = ':root {\n';
                for (const [shade, val] of Object.entries(colors)) {
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
                styleEl.textContent = css;
            },

            reset() {
                this.theme = 'modern';
                this.surface = 'default';
                this.contentWidth = '7xl';
                this.navLayout = 'sidebar-collapsible';
                this.sidebarWidth = '20rem';
                this.collapsedWidth = '4.5rem';
                this.radius = 'md';
                this.spacing = 'comfortable';
                this.font = 'Inter';
                this.fontSize = 'md';
                this.palette = 'amber';
                this.setDark(false);
                this.applyTheme();
                this.saveSettings();
            }
        }));
    });
</script>
