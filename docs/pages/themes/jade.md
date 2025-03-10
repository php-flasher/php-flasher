---
permalink: /theme/jade/
title: Jade Theme
description: Enhance your notifications with the calm, minimalist Jade theme for PHPFlasher. Featuring soft colors, rounded corners, and subtle animations for a soothing user experience.
handler: theme.jade
data-controller: theme-jade
---

## <i class="fa-solid fa-leaf"></i> Jade Theme

The Jade theme provides a calm, minimalist notification style with soft colors and subtle animations. It features a clean design that emphasizes message content through generous padding, rounded corners, and type-specific color schemes. The theme takes its name from the natural, soothing quality of its appearance.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Jade theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.jade',  // Make Jade the default theme
    
    'themes' => [
        'jade' => [
            'scripts' => [
                '/vendor/flasher/themes/jade.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/jade.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.jade  # Make Jade the default theme
    
    themes:
        jade:
            scripts:
                - '/vendor/flasher/themes/jade.min.js'
            styles:
                - '/vendor/flasher/themes/jade.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { jadeTheme } from '@flasher/flasher/themes';
flasher.addTheme('jade', jadeTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.jade';

// Or use it for specific notifications
flasher.success('Your changes have been saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Jade styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'An error occurred while saving your changes.' %}
{% assign warningMessage = 'Your session will expire in 5 minutes.' %}
{% assign infoMessage = 'New features have been added to your dashboard.' %}

<script type="text/javascript">
    messages['#/ jade types'] = [
        {
            handler: 'theme.jade',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'jade' },
        },
        {
            handler: 'theme.jade',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'jade' },
        },
        {
            handler: 'theme.jade',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'jade' },
        },
        {
            handler: 'theme.jade',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'jade' },
        }
    ];
</script>

### PHP

```php
#/ jade types

// With Jade set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Jade set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Jade Theme for Specific Notifications

If Jade isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.jade')
    ->success('This notification uses Jade theme.');
```

#### JavaScript

```javascript
flasher.use('theme.jade').success('This notification uses Jade theme.');
```

### Custom Colors and Appearance

The Jade theme uses CSS variables that can be customized to match your brand while maintaining its calm aesthetic:

```css
:root {
    /* Base appearance */
    --jade-text-light: #5f6c7b;                /* Text color in light mode */
    --jade-text-dark: #e2e8f0;                 /* Text color in dark mode */
    --jade-border-radius: 1rem;                /* Corner roundness */
    
    /* Type-specific colors - Light mode */
    --jade-success-bg: #f0fdf4;                /* Success background */
    --jade-success-color: #16a34a;             /* Success text/accent */
    --jade-info-bg: #eff6ff;                   /* Info background */
    --jade-info-color: #3b82f6;                /* Info text/accent */
    --jade-warning-bg: #fffbeb;                /* Warning background */
    --jade-warning-color: #f59e0b;             /* Warning text/accent */
    --jade-error-bg: #fef2f2;                  /* Error background */
    --jade-error-color: #dc2626;               /* Error text/accent */
    
    /* Dark mode backgrounds */
    --jade-success-bg-dark: rgba(22, 163, 74, 0.15);  /* Dark mode success */
    --jade-info-bg-dark: rgba(59, 130, 246, 0.15);    /* Dark mode info */
    --jade-warning-bg-dark: rgba(245, 158, 11, 0.15); /* Dark mode warning */
    --jade-error-bg-dark: rgba(220, 38, 38, 0.15);    /* Dark mode error */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Jade theme generates notifications with the following HTML structure:

```html
<div class="fl-jade fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

This minimalist structure focuses on content by omitting icons and unnecessary UI elements for a cleaner, more elegant look.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Design Philosophy

The Jade theme embodies several design principles:

1. **Simplicity**: Only essential elements are included, with no icons or extraneous components
2. **Softness**: Rounded corners, pastel colors, and subtle transitions create a gentle feel
3. **Clarity**: Clear color coding with strong contrast between background and text
4. **Refinement**: Thoughtful attention to details like animation timing and hover states
5. **Consistency**: Each notification type follows the same pattern with its own color scheme

### Color System

The Jade theme uses a dual-color system for each notification type:

- **Background**: Very light, pastel version of the type color (e.g., very light green for success)
- **Text/Accents**: More saturated version of the same color (e.g., medium green for success text)

This approach maintains excellent readability while providing clear visual differentiation between notification types.

### Animation

The Jade theme features a refined entrance animation that combines scaling and movement:

- Notifications fade in from invisible to fully visible
- They move upward slightly from their initial position
- They scale from 95% to 100% of their final size

This combination creates a more organic, refined entrance than simple fades or slides, using a carefully tuned easing curve for a natural feel.

### Dark Mode

The theme automatically adapts to system dark mode preferences, with semi-transparent colored backgrounds that create a subtle glow effect:

- Base text becomes lighter (#e2e8f0)
- Backgrounds use semi-transparent colored overlays (15% opacity)
- Hover states use white instead of black (10% white opacity)

This creates a cohesive dark appearance that maintains the theme's calm aesthetic.

### Accessibility Features

The Jade theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Button Labeling**: Close button has descriptive aria-label for screen readers

## <i class="fa-solid fa-browser"></i> Browser Support

The Jade theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Jade theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **CSS Animations**: For refined entrance effects
- **CSS Transitions**: For smooth hover interactions
- **Progress Bar**: Shows countdown until notification dismissal
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
