---
permalink: /theme/emerald/
title: Emerald Theme
description: Enhance your notifications with the elegant Emerald theme for PHPFlasher. Featuring a glass-like appearance with bounce animation and minimalist design for a modern, polished user experience.
handler: theme.emerald
data-controller: theme-emerald
---

## <i class="fa-solid fa-gem"></i> Emerald Theme

The Emerald theme provides an elegant, glass-like notification style with a distinctive bounce animation and translucent background. It focuses on minimalism and modern aesthetics, featuring colored text rather than backgrounds to indicate notification types.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Emerald theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.emerald',  // Make Emerald the default theme
    
    'themes' => [
        'emerald' => [
            'scripts' => [
                '/vendor/flasher/themes/emerald.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/emerald.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.emerald  # Make Emerald the default theme
    
    themes:
        emerald:
            scripts:
                - '/vendor/flasher/themes/emerald.min.js'
            styles:
                - '/vendor/flasher/themes/emerald.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { emeraldTheme } from '@flasher/flasher/themes';
flasher.addTheme('emerald', emeraldTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.emerald';

// Or use it for specific notifications
flasher.success('Your changes have been saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Emerald styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'An error occurred while saving your changes.' %}
{% assign warningMessage = 'Your session will expire soon.' %}
{% assign infoMessage = 'New features have been added to your dashboard.' %}

<script type="text/javascript">
    messages['#/ emerald types'] = [
        {
            handler: 'theme.emerald',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'emerald' },
        },
        {
            handler: 'theme.emerald',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'emerald' },
        },
        {
            handler: 'theme.emerald',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'emerald' },
        },
        {
            handler: 'theme.emerald',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'emerald' },
        }
    ];
</script>

### PHP

```php
#/ emerald types

// With Emerald set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Emerald set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Emerald Theme for Specific Notifications

If Emerald isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.emerald')
    ->success('This notification uses Emerald theme.');
```

#### JavaScript

```javascript
flasher.use('theme.emerald').success('This notification uses Emerald theme.');
```

### Custom Colors and Appearance

The Emerald theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base colors */
    --emerald-bg-light: rgba(255, 255, 255, 0.9);  /* Light background */
    --emerald-bg-dark: rgba(30, 30, 30, 0.9);      /* Dark background */
    --emerald-text-light: #333333;                 /* Light mode text */
    --emerald-text-dark: rgba(255, 255, 255, 0.9); /* Dark mode text */
    --emerald-shadow: rgba(0, 0, 0, 0.1);          /* Shadow color */
    --emerald-blur: 8px;                           /* Blur amount */
    
    /* Type colors */
    --emerald-success: #16a085;                    /* Success color */
    --emerald-error: #e74c3c;                      /* Error color */
    --emerald-warning: #f39c12;                    /* Warning color */
    --emerald-info: #3498db;                       /* Info color */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Emerald theme generates notifications with the following HTML structure:

```html
<div class="fl-emerald fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
</div>
```

This minimalist structure focuses on content by omitting unnecessary UI elements for a cleaner, more elegant look.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Distinctive Animation

The Emerald theme features a unique bounce animation that works as follows:

1. **Start**: The notification begins at 50% size and slightly below its final position
2. **Middle**: It quickly grows to 110% size and slightly above its final position
3. **End**: It settles back to 100% size at its final position

This creates a playful yet elegant "bounce" effect that draws attention without being too disruptive.

### Glass Morphism Effect

The theme uses CSS `backdrop-filter` to create a frosted glass effect, giving notifications a modern, translucent appearance with background blur.

### Dark Mode

The theme automatically adapts to system dark mode preferences without additional configuration, adjusting both the background transparency and text colors for optimal readability.

### Design Philosophy

The Emerald theme is named after its polished, refined appearance that gives notifications a gem-like quality. Its design principles include:

- **Simplicity**: Only essential elements are included
- **Elegance**: Soft blurs, shadows, and animations create a premium feel
- **Subtlety**: Colored text rather than backgrounds for a more refined look
- **Modernity**: Contemporary typography and glass-like effects
- **Focus**: Clear emphasis on the message content

### Accessibility Features

The Emerald theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Text Sizing**: Uses relative units (rem) for text to respect user font size preferences
- **Button Labels**: Close button has descriptive aria-label for screen readers

## <i class="fa-solid fa-browser"></i> Browser Support

The Emerald theme is compatible with all modern browsers:

- Chrome 76+
- Firefox 70+
- Safari 9+
- Edge 79+
- Opera 63+
- Mobile browsers on iOS and Android

For browsers that don't support backdrop-filter, the theme gracefully degrades to a translucent background without blur.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Emerald theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Backdrop Filter**: For the frosted glass effect
- **CSS Animations**: For the distinctive bounce entrance effect
- **Inter Font**: Optimized for clean, modern typography (with system font fallback)
- **Box Shadows**: For subtle depth and dimension
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
