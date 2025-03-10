---
permalink: /theme/aurora/
title: Aurora Theme
description: Add elegant glass-like notifications to your application with the Aurora theme for PHPFlasher. Featuring translucent backgrounds, subtle gradients, and modern backdrop blur effects.
handler: theme.aurora
data-controller: theme-aurora
---

## <i class="fa-solid fa-sparkles"></i> Aurora Theme

The Aurora theme provides an elegant, glass-like notification style with translucent backgrounds, subtle gradients, and backdrop blur effects. It offers a modern, refined aesthetic inspired by contemporary UI design trends like glass morphism.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Aurora theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.aurora',  // Make Aurora the default theme
    
    'themes' => [
        'aurora' => [
            'scripts' => [
                '/vendor/flasher/themes/aurora.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/aurora.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.aurora  # Make Aurora the default theme
    
    themes:
        aurora:
            scripts:
                - '/vendor/flasher/themes/aurora.min.js'
            styles:
                - '/vendor/flasher/themes/aurora.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { auroraTheme } from '@flasher/flasher/themes';
flasher.addTheme('aurora', auroraTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.aurora';

// Or use it for specific notifications
flasher.success('Your profile has been updated');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Aurora styling:

{% assign successMessage = 'Your profile has been updated successfully.' %}
{% assign errorMessage = 'Please check your connection and try again.' %}
{% assign warningMessage = 'Your session will expire in 5 minutes.' %}
{% assign infoMessage = 'New feature available in your dashboard.' %}

<script type="text/javascript">
    messages['#/ aurora types'] = [
        {
            handler: 'theme.aurora',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'aurora' },
        },
        {
            handler: 'theme.aurora',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'aurora' },
        },
        {
            handler: 'theme.aurora',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'aurora' },
        },
        {
            handler: 'theme.aurora',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'aurora' },
        }
    ];
</script>

### PHP

```php
#/ aurora types

// With Aurora set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Aurora set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Aurora Theme for Specific Notifications

If Aurora isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.aurora')
    ->success('This notification uses Aurora theme.');
```

#### JavaScript

```javascript
flasher.use('theme.aurora').success('This notification uses Aurora theme.');
```

### Custom Colors and Appearance

The Aurora theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --aurora-bg-light: rgba(255, 255, 255, 0.95);  /* Light background */
    --aurora-bg-dark: rgba(20, 20, 28, 0.92);      /* Dark background */
    --aurora-text-light: #1e293b;                  /* Light mode text */
    --aurora-text-dark: #f8fafc;                   /* Dark mode text */
    --aurora-border-radius: 16px;                  /* Corner radius */
    --aurora-blur: 15px;                           /* Blur amount */
    
    /* Type-specific colors */
    --aurora-success: #10b981;                     /* Success color */
    --aurora-info: #3b82f6;                        /* Info color */
    --aurora-warning: #f59e0b;                     /* Warning color */
    --aurora-error: #ef4444;                       /* Error color */
    
    /* Gradient colors */
    --aurora-success-gradient: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.2) 100%);
    --aurora-info-gradient: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(59, 130, 246, 0.2) 100%);
    --aurora-warning-gradient: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(245, 158, 11, 0.2) 100%);
    --aurora-error-gradient: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(239, 68, 68, 0.2) 100%);
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Aurora theme generates notifications with the following HTML structure:

```html
<div class="fl-aurora fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

This minimalist structure focuses on content by omitting unnecessary UI elements while still maintaining a progress bar that shows the time remaining before auto-dismiss.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Glass Morphism Effect

The Aurora theme uses CSS `backdrop-filter` to create its signature glass effect, giving notifications a modern, translucent appearance with background blur.

### Dark Mode

The theme automatically adapts to system dark mode preferences without additional configuration, adjusting both the background transparency and text colors for optimal readability.

### Accessibility Features

The Aurora theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: Maintains proper contrast ratios even with translucent backgrounds
- **Button Labels**: Close button has descriptive aria-label for screen readers

### Animation Technique

The entrance animation combines three effects for a refined appearance:

1. **Opacity**: Fade in from transparent to visible
2. **Translation**: Slight movement from above
3. **Scale**: Subtle growth from slightly smaller to full size

This combination creates a more organic, sophisticated appearance than simple fades or slides.

## <i class="fa-solid fa-browser"></i> Browser Support

The Aurora theme is compatible with all modern browsers that support CSS variables and backdrop filters:

- Chrome 76+
- Firefox 70+
- Safari 9+
- Edge 17+
- Opera 64+
- Mobile browsers on iOS and Android

For browsers that don't support backdrop filters, the theme gracefully degrades to using just the translucent background.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Aurora theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Backdrop Filter**: For the frosted glass effect
- **Gradient Overlays**: Using `::before` pseudo-elements for type-specific styling
- **CSS Animations**: For smooth entrance effects and progress bar
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
