---
permalink: /theme/neon/
title: Neon Theme
description: Add elegant notifications with subtle glowing accents to your application using the Neon theme for PHPFlasher. Featuring frosted glass backgrounds, floating illuminated indicators, and refined typography.
handler: theme.neon
data-controller: theme-neon
---

## <i class="fa-solid fa-lightbulb"></i> Neon Theme

The Neon theme provides elegant notifications with subtle glowing accents that evoke the gentle illumination of neon lights. It features a frosted glass background, floating illuminated indicators, and refined typography that come together to create a modern, sophisticated appearance.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Neon theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.neon',  // Make Neon the default theme
    
    'themes' => [
        'neon' => [
            'scripts' => [
                '/vendor/flasher/themes/neon.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/neon.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.neon  # Make Neon the default theme
    
    themes:
        neon:
            scripts:
                - '/vendor/flasher/themes/neon.min.js'
            styles:
                - '/vendor/flasher/themes/neon.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { neonTheme } from '@flasher/flasher/themes';
flasher.addTheme('neon', neonTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.neon';

// Or use it for specific notifications
flasher.success('Your changes have been saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Neon styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'There was a problem saving your changes.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New features are available.' %}

<script type="text/javascript">
    messages['#/ neon types'] = [
        {
            handler: 'theme.neon',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'neon' },
        },
        {
            handler: 'theme.neon',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'neon' },
        },
        {
            handler: 'theme.neon',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'neon' },
        },
        {
            handler: 'theme.neon',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'neon' },
        }
    ];
</script>

### PHP

```php
#/ neon types

// With Neon set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Neon set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Neon Theme for Specific Notifications

If Neon isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.neon')
    ->success('This notification uses Neon theme.');
```

#### JavaScript

```javascript
flasher.use('theme.neon').success('This notification uses Neon theme.');
```

### Custom Colors and Appearance

The Neon theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --neon-bg-light: rgba(255, 255, 255, 0.9);    /* Light mode background */
    --neon-bg-dark: rgba(15, 23, 42, 0.9);        /* Dark mode background */
    --neon-text-light: #334155;                   /* Light mode text */
    --neon-text-dark: #f1f5f9;                    /* Dark mode text */
    --neon-border-radius: 12px;                   /* Corner roundness */
    
    /* Glow colors */
    --neon-success: #10b981;                      /* Success color */
    --neon-info: #3b82f6;                         /* Info color */
    --neon-warning: #f59e0b;                      /* Warning color */
    --neon-error: #ef4444;                        /* Error color */
    
    /* Glow properties */
    --neon-glow-strength: 10px;                   /* How far the glow extends */
    --neon-blur: 10px;                            /* Backdrop blur amount */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Neon theme generates notifications with the following HTML structure:

```html
<div class="fl-neon fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

The floating illuminated indicator is created using CSS pseudo-elements rather than being part of the HTML structure.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Floating Illuminated Indicator

The Neon theme features a distinctive floating indicator that appears to hover above the notification with a subtle glow:

1. **Container**: Positioned above the notification's top edge
2. **Glow**: Applied using a filter drop-shadow with the notification type's color
3. **Background**: Semi-transparent circle created with ::before pseudo-element
4. **Center dot**: Solid-colored small dot created with ::after pseudo-element

This layering creates the illusion of a floating, glowing dot that serves as a visual indicator of the notification type.

### Animation Effects

The Neon theme features two distinctive animations:

#### Entrance Animation

A combined animation creates a refined entrance where notifications:
1. Fade in from invisible to fully visible
2. Move downward slightly from above
3. Transition from a blurred state to sharp focus

#### Glow Animation

A subtle "breathing" effect where the glow gently pulses, becoming slightly dimmer in the middle of the animation cycle before returning to full brightness.

### Frosted Glass Effect

The theme uses a semi-transparent background combined with backdrop-filter to create a frosted glass effect that gives notifications a modern, sophisticated appearance where they appear to float above the page with a subtle blur applied to content behind them.

### Dark Mode

The dark mode implementation maintains the glowing aesthetic while adjusting for low-light environments:

- Dark slate semi-transparent background
- Light colored text for better contrast
- Stronger shadow for better depth perception
- Adjusted hover state for the close button

The glowing colors remain consistent between light and dark modes to maintain brand color recognition.

### Accessibility Features

The Neon theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables both entrance and glow animations
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Contrast**: Maintains sufficient contrast ratio between text and background
- **Visual Indicators**: Uses both color and position to signal notification type

## <i class="fa-solid fa-browser"></i> Browser Support

The Neon theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

For browsers that don't support backdrop-filter (like Firefox), the theme gracefully degrades to using just the semi-transparent background without the blur effect.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Neon theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **CSS Pseudo-elements**: For creating the floating indicator without extra HTML
- **Backdrop Filter**: For the frosted glass effect
- **Filter Effects**: For creating the glowing appearance
- **CSS Animations**: For entrance and glow pulsing effects
- **Typography**: Uses Inter font (with fallbacks) for a clean, modern look
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.

For the best experience with the Neon theme, it's recommended to include the Inter font in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
```
