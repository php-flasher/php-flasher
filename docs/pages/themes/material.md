---
permalink: /theme/material/
title: Material Theme
description: Add minimalist Material Design notifications to your application with the Material theme for PHPFlasher. Featuring clean cards, proper elevation, and interactive elements following Material guidelines.
handler: theme.material
data-controller: theme-material
---

## <i class="fa-solid fa-square"></i> Material Theme

The Material theme provides a minimalist implementation of Google's Material Design system for notifications. It features clean cards with proper elevation, Material Design typography, and interactive elements that follow Material guidelines, all without unnecessary visual elements to maintain focus on the message content.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Material theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.material',  // Make Material the default theme
    
    'themes' => [
        'material' => [
            'scripts' => [
                '/vendor/flasher/themes/material.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/material.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.material  # Make Material the default theme
    
    themes:
        material:
            scripts:
                - '/vendor/flasher/themes/material.min.js'
            styles:
                - '/vendor/flasher/themes/material.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { materialTheme } from '@flasher/flasher/themes';
flasher.addTheme('material', materialTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.material';

// Or use it for specific notifications
flasher.success('Operation completed successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Material styling:

{% assign successMessage = 'Operation completed successfully.' %}
{% assign errorMessage = 'An error occurred during the operation.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New updates are available.' %}

<script type="text/javascript">
    messages['#/ material types'] = [
        {
            handler: 'theme.material',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'material' },
        },
        {
            handler: 'theme.material',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'material' },
        },
        {
            handler: 'theme.material',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'material' },
        },
        {
            handler: 'theme.material',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'material' },
        }
    ];
</script>

### PHP

```php
#/ material types

// With Material set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Material set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Material Theme for Specific Notifications

If Material isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.material')
    ->success('This notification uses Material theme.');
```

#### JavaScript

```javascript
flasher.use('theme.material').success('This notification uses Material theme.');
```

### Custom Colors and Appearance

The Material theme uses CSS variables that can be customized to match your brand while maintaining the Material Design feel:

```css
:root {
    /* Base appearance */
    --md-bg-light: #ffffff;              /* Light mode background */
    --md-bg-dark: #2d2d2d;               /* Dark mode background */
    --md-text-light: rgba(0, 0, 0, 0.87); /* Primary text in light mode */
    --md-text-secondary-light: rgba(0, 0, 0, 0.6); /* Secondary text in light mode */
    --md-text-dark: rgba(255, 255, 255, 0.87); /* Primary text in dark mode */
    --md-text-secondary-dark: rgba(255, 255, 255, 0.6); /* Secondary text in dark mode */
    --md-elevation: 0 3px 5px -1px rgba(0,0,0,0.2), 0 6px 10px 0 rgba(0,0,0,0.14), 0 1px 18px 0 rgba(0,0,0,0.12); /* Card shadow */
    --md-border-radius: 4px;             /* Card corner radius */
    
    /* Type colors - based on Material palette */
    --md-success: #43a047;               /* Green 600 */
    --md-info: #1e88e5;                  /* Blue 600 */
    --md-warning: #fb8c00;               /* Orange 600 */
    --md-error: #e53935;                 /* Red 600 */
    
    /* Animation timing */
    --md-animation-duration: 0.3s;       /* Entrance animation duration */
    --md-ripple-duration: 0.6s;          /* Button ripple effect duration */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Material theme generates notifications with the following HTML structure:

```html
<div class="fl-material fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-md-card">
        <div class="fl-content">
            <div class="fl-text-content">
                <div class="fl-message">Message text</div>
            </div>
        </div>
        <div class="fl-actions">
            <button class="fl-action-button fl-close" aria-label="Close [type] message">
                DISMISS
            </button>
        </div>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

This minimalist structure focuses on content by omitting unnecessary UI elements for a cleaner appearance.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Material Design Elements

#### Elevation

The theme uses proper Material Design elevation with three shadow components:

1. **Umbra**: The darkest, sharpest shadow representing the main shadow
2. **Penumbra**: The mid-tone, slightly softer shadow
3. **Ambient**: The lightest, most diffuse shadow

This creates the characteristic Material Design "floating" effect for cards.

#### Typography

Following Material Design typography guidelines:

- **Message**: 14px (0.875rem), regular weight (400), 60% opacity for secondary text
- **Button**: 13px (0.8125rem), medium weight (500), uppercase with letterSpacing

#### Ripple Effect

The theme includes Material Design's signature "ink ripple" effect:

1. A small circle appears at the point of interaction
2. The circle rapidly expands outward
3. The effect fades out as it reaches full size

This provides visual feedback that enhances the tactile feeling of the interface.

### Animation Details

The Material theme uses Material Design's standard motion curve (cubic-bezier(0.4, 0, 0.2, 1)) for its slide-up animation. This creates a natural-feeling motion that follows the principles of Material motion:

- Quick acceleration from start
- Smooth deceleration to end
- Total duration of 300ms

The theme also includes several interaction animations:

1. **Button Hover**: Background color transition (200ms)
2. **Button Press**: Ripple effect (600ms)
3. **Progress Bar**: Linear progress animation

### Differences from Google Theme

While both the Material theme and Google theme follow Material Design guidelines, they differ in these key ways:

1. **Minimalist Approach**: The Material theme omits icons entirely for a more streamlined appearance
2. **Focus on Content**: With fewer visual elements, more focus is placed on the message text
3. **Simplified Structure**: The HTML structure is more straightforward without icon containers

### Dark Mode

The Material theme implements Material Design's dark theme guidelines:

- Dark surfaces (#2d2d2d)
- Light text (87% white for primary, 60% white for secondary)
- Adjusted shadows for better visibility on dark backgrounds
- Higher contrast for hover states (8% opacity instead of 4%)

### Accessibility Features

The Material theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables animations
- **Keyboard Access**: Action button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Text Alternatives**: Descriptive aria-labels for interactive elements

## <i class="fa-solid fa-browser"></i> Browser Support

The Material theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

The ripple effect and other animations may have slightly different appearances across browsers, but the core functionality works everywhere.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Material theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Material Design Elevation**: Proper shadow implementation for depth
- **Ripple Animation**: For tactile button feedback
- **CSS Animations**: With Material Design easing curves
- **Linear Progress**: For countdown visualization
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.

For the best experience, it's recommended to include the Roboto font in your project:

```html
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
```
