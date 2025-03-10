---
permalink: /theme/amber/
title: Amber Theme
description: Transform your notifications with the elegant Amber theme for PHPFlasher. Featuring a modern, minimalist design with subtle animations and comprehensive dark mode support.
handler: theme.amber
data-controller: theme-amber
---

## <i class="fa-solid fa-sun"></i> Amber Theme

The Amber theme offers a modern, elegant notification style with refined aesthetics that focuses on clean design and readability. It provides a minimalist approach while maintaining visual appeal with subtle animations and transitions.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Amber theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.amber',  // Make Amber the default theme
    
    'themes' => [
        'amber' => [
            'scripts' => [
                '/vendor/flasher/themes/amber.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/amber.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.amber  # Make Amber the default theme
    
    themes:
        amber:
            scripts:
                - '/vendor/flasher/themes/amber.min.js'
            styles:
                - '/vendor/flasher/themes/amber.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { amberTheme } from '@flasher/flasher/themes';
flasher.addTheme('amber', amberTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.amber';

// Or use it for specific notifications
flasher.success('Your changes have been saved successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Amber styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'An error occurred while saving your changes.' %}
{% assign warningMessage = 'Your session will expire in 5 minutes.' %}
{% assign infoMessage = 'New features have been added to your account.' %}

<script type="text/javascript">
    messages['#/ amber types'] = [
        {
            handler: 'theme.amber',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'amber' },
        },
        {
            handler: 'theme.amber',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'amber' },
        },
        {
            handler: 'theme.amber',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'amber' },
        },
        {
            handler: 'theme.amber',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'amber' },
        }
    ];
</script>

### PHP

```php
#/ amber types

// With Amber set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Amber set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Amber Theme for Specific Notifications

If Amber isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.amber')
    ->success('This notification uses Amber theme.');
```

#### JavaScript

```javascript
flasher.use('theme.amber').success('This notification uses Amber theme.');
```

### Custom Colors

The Amber theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --amber-bg-light: #ffffff;          /* Light mode background */
    --amber-bg-dark: #1e293b;           /* Dark mode background */
    --amber-text-light: #4b5563;        /* Light mode text */
    --amber-text-dark: #f1f5f9;         /* Dark mode text */
    --amber-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); /* Light mode shadow */
    --amber-border-radius: 0.4rem;      /* Border radius */

    /* Type-specific colors */
    --amber-success: #10b981;           /* Success color */
    --amber-info: #3b82f6;              /* Info color */
    --amber-warning: #f59e0b;           /* Warning color */
    --amber-error: #ef4444;             /* Error color */
    
    /* Dark mode shadows */
    --amber-shadow-dark: 0 5px 15px rgba(0, 0, 0, 0.25);
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Amber theme generates notifications with the following HTML structure:

```html
<div class="fl-amber fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-icon"></div>
        <div class="fl-text">
            <div class="fl-message">Message text</div>
        </div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

This structure includes a progress bar that shows the time remaining before the notification auto-dismisses.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Dark Mode

The Amber theme automatically adapts to system dark mode preferences without additional configuration using the `prefers-color-scheme` media query.

### Accessibility Features

The Amber theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Button Labels**: Close button has descriptive aria-label for screen readers

### Key Differences from Default Theme

The Amber theme differs from the default theme in several ways:

1. **More Minimal**: Cleaner design with less ornamentation
2. **Subtle Shadows**: Uses softer box shadows for a modern look
3. **Smaller Icon**: Uses a more compact icon size
4. **Progress Bar**: Visual indicator for auto-dismiss timing
5. **Different Animation**: Uses a top-down entrance animation
6. **Colored Close Button**: Close button color matches notification type

## <i class="fa-solid fa-browser"></i> Browser Support

The Amber theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Amber theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Flexbox Layout**: For responsive and flexible notification structure
- **CSS Animations**: For entrance effects and progress bar
- **Media Queries**: For responsive design, dark mode, and reduced motion support
- **Core Icons**: Uses the PHPFlasher core icon system

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
