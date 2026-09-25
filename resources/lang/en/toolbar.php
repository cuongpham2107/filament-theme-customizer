<?php

return [
    'launcher' => [
        'label' => 'Theme Studio',
        'title' => 'Customize Theme & Layout',
    ],

    'heading' => 'Filament Theme Studio',
    'subheading' => 'Zero-reload instantaneous customization',
    'close' => 'Close',

    'sections' => [
        'theme' => 'Theme Preset',
        'color_mode' => 'Color Mode',
        'nav_layout' => 'Navigation Layout',
        'sidebar_width' => 'Sidebar Width',
        'content_width' => 'Content Width',
        'surface' => 'Background Surface',
        'primary_color' => 'Primary Color',
        'radius' => 'Border Radius',
        'spacing' => 'Spacing & Density',
        'font' => 'Font Family',
        'font_size' => 'Font Size',
    ],

    'themes' => [
        'modern' => ['label' => 'Modern', 'description' => 'Clean & balanced'],
        'precision' => ['label' => 'Precision', 'description' => 'Crisp & architectural'],
        'velvet' => ['label' => 'Velvet', 'description' => 'Warm & soft curves'],
        'obsidian' => ['label' => 'Obsidian', 'description' => 'High-contrast dark depth'],
    ],

    'color_modes' => [
        'light' => 'Light',
        'dark' => 'Dark',
    ],

    'nav_layouts' => [
        'sidebar-collapsible' => ['label' => 'Collapsible', 'badge' => 'Collapsible', 'title' => 'Collapsible on Desktop (Icons only)'],
        'sidebar-fully-collapsible' => ['label' => 'Slide', 'badge' => 'Full Slide', 'title' => 'Fully Collapsible (Slides offscreen)'],
        'sidebar-fixed' => ['label' => 'Fixed', 'badge' => 'Fixed', 'title' => 'Fixed Expanded Sidebar'],
        'top' => ['label' => 'Top Nav', 'badge' => 'Top Nav', 'title' => 'Top Navigation Bar (Horizontal)'],
    ],

    'sidebar_widths' => [
        'slim' => 'Slim (16rem / 256px)',
        'compact' => 'Compact (18rem / 288px)',
        'default' => 'Default (20rem / 320px)',
        'wide' => 'Wide (22rem / 352px)',
        'comfortable' => 'Comfortable (24rem / 384px)',
    ],

    'content_widths' => [
        'full' => 'Full',
        'full_badge' => 'Full (100%)',
        'full_title' => '100% Full Width (Edge to Edge)',
        'screen_2xl_title' => 'Ultrawide 1536px (Screen 2XL)',
        '7xl_title' => 'Default 1280px (7XL)',
        'scale' => 'Tailwind scale:',
        'group_screen' => 'Full & Screen Scale',
        'group_standard' => 'Standard Max-Width Scale',
        'group_content' => 'Content Scale',
        'option_full' => 'Full (100% Edge-to-Edge)',
        'option_7xl' => '7XL (1280px - Default)',
        'prose' => 'Prose',
        'option_prose' => 'Prose (65ch text)',
        'option_fit' => 'Fit Content',
        'option_max' => 'Max Content',
        'option_min' => 'Min Content',
    ],

    'surfaces' => [
        'default' => 'Default',
        'linen' => 'Linen',
        'slate' => 'Slate',
        'stone' => 'Stone',
        'pure' => 'Pure',
    ],

    'palettes' => [
        'amber' => 'Amber',
        'blue' => 'Blue',
        'forest' => 'Forest Green',
        'citrus' => 'Citrus Orange',
        'violet' => 'Violet',
        'rose' => 'Rose',
        'teal' => 'Teal',
        'zinc' => 'Zinc',
    ],

    'radii' => [
        'sharp' => '0px (Sharp)',
        'pill' => 'Pill',
    ],

    'spacings' => [
        'tight' => ['label' => 'Tight', 'title' => 'Ultra-compact tables and forms'],
        'compact' => ['label' => 'Compact', 'title' => 'Compact desktop view'],
        'comfortable' => ['label' => 'Normal', 'title' => 'Standard comfortable spacing'],
        'spacious' => ['label' => 'Spacious', 'title' => 'Airy and relaxed spacing'],
    ],

    'font_size_slider' => 'Font Size Slider',

    'persistence' => [
        'heading' => 'Save & Sync',
        'customized' => 'Customized',
        'using_default' => 'Using default',
        'save_user' => '💾 Save my settings',
        'saving_user' => 'Saving to your account...',
        'reset_user' => '↺ Back to system default',
        'resetting_user' => 'Restoring...',
        'save_global' => '⭐ Set as system-wide default',
        'saving_global' => 'Saving default...',
        'save_global_title' => 'Save this theme as the default for all guests and every new user',
        'save_global_hint' => 'Applies to the login page & all new users',
    ],

    'notifications' => [
        'user_saved' => '✓ Your personal settings have been saved!',
        'user_save_failed' => 'Failed to save settings.',
        'user_reset' => '✓ Restored to the system default!',
        'user_reset_failed' => 'Failed to restore.',
        'global_confirm' => 'Are you sure you want to set the current theme as the DEFAULT for the whole system & all new users?',
        'global_saved' => '⭐ Saved as the system-wide default!',
        'global_save_failed' => 'Failed to save the system-wide default.',
        'connection_error' => 'Could not connect to the server.',
    ],

    'reset_all' => 'Reset all to default',
    'credit' => 'Free Plugin',
];
