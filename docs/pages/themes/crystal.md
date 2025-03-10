---
permalink: /theme/crystal/
title: Crystal Theme
description: Enhance your notifications with the elegant Crystal theme for PHPFlasher. Featuring a clean, monochromatic design with colored text and subtle animation effects.
handler: theme.crystal
data-controller: theme-crystal
---

## <i class="fa-solid fa-diamond"></i> Crystal Theme

The Crystal theme provides an elegant, clean notification style with subtle animations and a focus on simplicity. It features a monochromatic design with type-specific colored text and a gentle pulsing shadow effect on hover.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Crystal theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.crystal',  // Make Crystal the default theme
    
    'themes' => [
        'crystal' => [
            'scripts' => [
                '/vendor/flasher/themes/crystal.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/crystal.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.crystal  # Make Crystal the default theme
    
    themes:
        crystal:
            scripts:
                - '/vendor/flasher/themes/crystal.min.js'
            styles:
                - '/vendor/flasher/themes/crystal.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { crystalTheme } from '@flasher/flasher/themes';
flasher.addTheme('crystal', crystalTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.crystal';

// Or use it for specific notifications
flasher.success('Document saved successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Crystal styling:

{% assign successMessage = 'Document saved successfully.' %}
{% assign errorMessage = 'An error occurred while saving your document.' %}
{% assign warningMessage = 'Your session will expire in 5 minutes.' %}
{% assign infoMessage = 'New features have been added to the editor.' %}

<script type="text/javascript">
    messages['#/ crystal types'] = [
        {
            handler: 'theme.crystal',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'crystal' },
        },
        {
            handler: 'theme.crystal',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'crystal' },
        },
        {
            handler: 'theme.crystal',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'crystal' },
        },
        {
            handler: 'theme.crystal',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'crystal' },
        }
    ];
</script>

### PHP

```php
#/ crystal types

// With Crystal set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Crystal set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Crystal Theme for Specific Notifications

If Crystal isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.crystal')
    ->success('This notification uses Crystal theme.');
```

#### JavaScript

```javascript
flasher.use('theme.crystal').success('This notification uses Crystal theme.');
```

### Custom Colors and Appearance

The Crystal theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --crystal-bg-light: #ffffff;                  /* Light mode background */
    --crystal-bg-dark: rgba(30, 30, 30, 0.95);    /* Dark mode background */
    --crystal-text-light: #2c3e50;                /* Light mode text */
    --crystal-text-dark: rgba(255, 255, 255, 0.95); /* Dark mode text */
    --crystal-shadow: rgba(0, 0, 0, 0.08);        /* Light mode shadow */
    --crystal-shadow-dark: rgba(0, 0, 0, 0.25);   /* Dark mode shadow */
    
    /* Type colors (uses default PHPFlasher colors) */
    --fl-success: #10b981;                        /* Success color */
    --fl-info: #3b82f6;                           /* Info color */
    --fl-warning: #f59e0b;                        /* Warning color */
    --fl-error: #ef4444;                          /* Error color */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Crystal theme generates notifications with the following HTML structure:

```html
<div class="fl-crystal fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-text">
            <p class="fl-message">Message text</p>
        </div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

This minimalist structure focuses on content with a clean design, while still maintaining a progress bar that shows the time remaining before auto-dismiss.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Elegant Animations

The Crystal theme features two distinct animations:

1. **Entrance Animation**: A smooth slide-in from above with a fade-in effect
2. **Hover Animation**: A gentle pulsing shadow that creates a subtle "breathing" effect

The hover animation is disabled in dark mode and for users who prefer reduced motion, replaced with a static enhanced shadow effect.

### Dark Mode

The theme automatically adapts to system dark mode preferences without additional configuration, adjusting both the background and text colors for optimal readability.

### Design Philosophy

The Crystal theme embodies clarity and simplicity. Rather than using colored backgrounds or borders, it employs colored text to indicate notification types. This creates a cleaner, more sophisticated appearance while still providing clear visual cues about the notification's nature.

### Accessibility Features

The Crystal theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables animations
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Contrast**: High contrast between text and background for readability
- **Button Labels**: Close button has descriptive aria-label for screen readers

## <i class="fa-solid fa-browser"></i> Browser Support

The Crystal theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Crystal theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **CSS Transitions**: For smooth hover effects
- **Keyframe Animations**: For entrance and pulsing shadow effects
- **Absolute Positioning**: For consistent close button layout
- **Progress Bar**: Shows countdown until notification dismissal
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
