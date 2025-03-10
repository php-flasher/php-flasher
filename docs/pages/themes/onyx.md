---
permalink: /theme/onyx/
title: Onyx Theme
description: Add modern, floating notifications to your application with the Onyx theme for PHPFlasher. Featuring elegant shadows, colored corner dots, and smooth animations for a sophisticated appearance.
handler: theme.onyx
data-controller: theme-onyx
---

## <i class="fa-solid fa-gem"></i> Onyx Theme

The Onyx theme provides modern, floating notifications with a clean design and subtle accent elements. It features elegant shadows, colored corner dots indicating notification type, and smooth animations to create a sophisticated, contemporary appearance that integrates well with modern interfaces.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Onyx theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.onyx',  // Make Onyx the default theme
    
    'themes' => [
        'onyx' => [
            'scripts' => [
                '/vendor/flasher/themes/onyx.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/onyx.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.onyx  # Make Onyx the default theme
    
    themes:
        onyx:
            scripts:
                - '/vendor/flasher/themes/onyx.min.js'
            styles:
                - '/vendor/flasher/themes/onyx.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { onyxTheme } from '@flasher/flasher/themes';
flasher.addTheme('onyx', onyxTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.onyx';

// Or use it for specific notifications
flasher.success('Your changes have been saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Onyx styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'There was a problem saving your changes.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New features are available.' %}

<script type="text/javascript">
    messages['#/ onyx types'] = [
        {
            handler: 'theme.onyx',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'onyx' },
        },
        {
            handler: 'theme.onyx',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'onyx' },
        },
        {
            handler: 'theme.onyx',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'onyx' },
        },
        {
            handler: 'theme.onyx',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'onyx' },
        }
    ];
</script>

### PHP

```php
#/ onyx types

// With Onyx set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Onyx set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Onyx Theme for Specific Notifications

If Onyx isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.onyx')
    ->success('This notification uses Onyx theme.');
```

#### JavaScript

```javascript
flasher.use('theme.onyx').success('This notification uses Onyx theme.');
```

### Custom Colors and Appearance

The Onyx theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --onyx-bg-light: #ffffff;                    /* Light mode background */
    --onyx-bg-dark: #1e1e1e;                     /* Dark mode background */
    --onyx-text-light: #333333;                  /* Light mode text */
    --onyx-text-dark: #f5f5f5;                   /* Dark mode text */
    --onyx-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); /* Light mode shadow */
    --onyx-shadow-dark: 0 8px 30px rgba(0, 0, 0, 0.25); /* Dark mode shadow */
    --onyx-border-radius: 1rem;                  /* Corner roundness */
    
    /* Accent colors */
    --onyx-success: #10b981;                     /* Success color */
    --onyx-info: #3b82f6;                        /* Info color */
    --onyx-warning: #f59e0b;                     /* Warning color */
    --onyx-error: #ef4444;                       /* Error color */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Onyx theme generates notifications with the following HTML structure:

```html
<div class="fl-onyx fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
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

The accent dots are created using CSS pseudo-elements (`::before` and `::after`) rather than being part of the HTML structure.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Design Philosophy

The Onyx theme embodies several design principles:

1. **Elegance**: Clean, sophisticated appearance with subtle details
2. **Minimalism**: Only essential elements are included, with no icons or extraneous components
3. **Focus**: The clean design keeps attention on the message content
4. **Refinement**: Thoughtful attention to details like animation timing and corner dots 
5. **Consistency**: Each notification type follows the same pattern with its own accent color

### Accent Dots Design

One of the distinctive features of the Onyx theme is its use of subtle accent dots in the corners:

- **Top-left dot**: Positioned 10px from the top and left edges
- **Bottom-right dot**: Positioned 10px from the bottom and right edges
- **Small size**: Each dot is just 6px in diameter
- **Type-specific colors**: The dots match the color associated with the notification type

These small visual elements provide a subtle but clear indication of the notification type without requiring large icons or colored backgrounds.

### Animation Effects

The Onyx theme features a sophisticated entrance animation that combines multiple effects:

- Notifications fade in from invisible to fully visible
- They move upward slightly from below their final position
- They transition from a blurred state to sharp focus

The animation uses a carefully crafted easing curve for a natural, refined movement.

### Dark Mode

The dark mode implementation maintains the sophisticated aesthetic while adjusting for low-light environments:

- Dark background (#1e1e1e)
- Light text color (#f5f5f5)
- Deeper shadow for enhanced depth perception
- Adjusted hover state for the close button using white opacity

The accent dot colors remain consistent between light and dark modes to maintain brand color recognition.

### Accessibility Features

The Onyx theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables entrance animation
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Indicators**: Uses colored dots to indicate type without relying solely on color for meaning
- **Adequate Contrast**: Ensures good contrast between text and background in both light and dark modes

## <i class="fa-solid fa-browser"></i> Browser Support

The Onyx theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

No special polyfills or fallbacks are required as the theme uses standard CSS features that are well-supported across browsers.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Onyx theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **CSS Pseudo-elements**: For creating the accent dots without extra HTML
- **Box Shadows**: For the floating card appearance
- **CSS Animations**: For refined entrance effects combining movement and blur
- **CSS Transitions**: For smooth hover interactions
- **Progress Bar**: Shows countdown until notification dismissal with type-specific colors
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
