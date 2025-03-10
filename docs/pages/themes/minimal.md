---
permalink: /theme/minimal/
title: Minimal Theme
description: Enhance your application with ultra-clean, distraction-free notifications using the Minimal theme for PHPFlasher. Featuring a translucent design with subtle styling for unobtrusive messaging.
handler: theme.minimal
data-controller: theme-minimal
---

## <i class="fa-solid fa-minus"></i> Minimal Theme

The Minimal theme provides an ultra-clean, distraction-free notification design that prioritizes simplicity and unobtrusiveness. With its compact dimensions, subtle visual styling, and reduced visual elements, this theme is perfect for applications where notifications should provide information without competing for attention with the main interface.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Minimal theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.minimal',  // Make Minimal the default theme
    
    'themes' => [
        'minimal' => [
            'scripts' => [
                '/vendor/flasher/themes/minimal.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/minimal.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.minimal  # Make Minimal the default theme
    
    themes:
        minimal:
            scripts:
                - '/vendor/flasher/themes/minimal.min.js'
            styles:
                - '/vendor/flasher/themes/minimal.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { minimalTheme } from '@flasher/flasher/themes';
flasher.addTheme('minimal', minimalTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.minimal';

// Or use it for specific notifications
flasher.success('Changes saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Minimal styling:

{% assign successMessage = 'Changes saved.' %}
{% assign errorMessage = 'Connection lost.' %}
{% assign warningMessage = 'Low disk space.' %}
{% assign infoMessage = 'Updates available.' %}

<script type="text/javascript">
    messages['#/ minimal types'] = [
        {
            handler: 'theme.minimal',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'minimal' },
        },
        {
            handler: 'theme.minimal',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'minimal' },
        },
        {
            handler: 'theme.minimal',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'minimal' },
        },
        {
            handler: 'theme.minimal',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'minimal' },
        }
    ];
</script>

### PHP

```php
#/ minimal types

// With Minimal set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Minimal set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Minimal Theme for Specific Notifications

If Minimal isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.minimal')
    ->success('This notification uses Minimal theme.');
```

#### JavaScript

```javascript
flasher.use('theme.minimal').success('This notification uses Minimal theme.');
```

### Custom Colors and Appearance

The Minimal theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --minimal-bg-light: rgba(255, 255, 255, 0.8);  /* Light mode background */
    --minimal-bg-dark: rgba(25, 25, 25, 0.8);      /* Dark mode background */
    --minimal-text-light: #333333;                 /* Light mode text */
    --minimal-text-dark: #f5f5f5;                  /* Dark mode text */
    --minimal-border-radius: 6px;                  /* Corner radius */
    
    /* Type colors */
    --minimal-success: rgba(34, 197, 94, 0.9);     /* Success color */
    --minimal-info: rgba(14, 165, 233, 0.9);       /* Info color */
    --minimal-warning: rgba(245, 158, 11, 0.9);    /* Warning color */
    --minimal-error: rgba(239, 68, 68, 0.9);       /* Error color */
    
    /* Additional customization */
    --minimal-blur: 8px;                          /* Backdrop blur amount */
    --minimal-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Shadow */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Minimal theme generates notifications with the following HTML structure:

```html
<div class="fl-minimal fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-dot"></div>
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

This structure is deliberately minimalist, with just a small colored dot to indicate notification type and a thin progress bar at the bottom.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Design Philosophy

The Minimal theme embodies several key design principles:

1. **Reduction**: Eliminating all non-essential visual elements
2. **Unobtrusiveness**: Staying out of the way while delivering information
3. **Clarity**: Maintaining excellent readability with system fonts
4. **Subtlety**: Using transparency, small indicators, and minimal animation
5. **Consistency**: Applying the same minimal approach to all aspects

The theme deliberately avoids large icons, bold colors, or pronounced animations that might distract users from their primary tasks. The small colored dot provides just enough visual indication of the notification type without overwhelming the interface.

### Visual Characteristics

#### Frosted Glass Effect

The theme uses a semi-transparent background (80% opacity) with an 8px backdrop blur, creating a subtle "frosted glass" effect that lets the underlying content partially show through.

#### System Font Stack

The theme uses the system UI font of the user's device (San Francisco on Apple devices, Segoe UI on Windows, etc.), ensuring that notifications look native to the platform.

#### Compact Size and Spacing

- **Max Width**: 320px
- **Padding**: 0.75rem 1rem (12px 16px at default font size)
- **Text Size**: 0.875rem (14px at default font size)
- **Dot Size**: 8px diameter

#### Quick Animation

The entrance animation is intentionally brief (0.2s) and subtle, with just a small movement from above and fade-in effect.

### Dark Mode

The theme automatically adapts to system dark mode preferences, with a dark semi-transparent background and light text that maintains the minimal aesthetic while ensuring readability.

### Accessibility Features

The Minimal theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Indications**: Uses color dots to indicate type without relying solely on color
- **System Fonts**: Improved readability through native font rendering
- **Adequate Contrast**: Maintains good contrast ratio between text and background

## <i class="fa-solid fa-browser"></i> Browser Support

The Minimal theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest) - falls back gracefully to semi-transparent background without blur
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Minimal theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Backdrop Filter**: For the subtle frosted glass effect
- **System Font Stack**: For optimal readability with native fonts
- **CSS Transitions**: For subtle hover effects
- **CSS Animations**: For quick, minimal entrance animation
- **Performance Optimization**: Uses `will-change: transform, opacity` for smooth animations
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times and minimal impact on application performance.

