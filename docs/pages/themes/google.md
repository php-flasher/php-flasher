---
permalink: /theme/google/
title: Google Theme
description: Add Material Design-inspired notifications to your application with the Google theme for PHPFlasher. Featuring Google's card-based layout, typography, and interactive elements like ripple effects.
handler: theme.google
data-controller: theme-google
---

## <i class="fa-brands fa-google"></i> Google Theme

The Google theme provides notifications inspired by Google's Material Design system, one of the most recognized design languages worldwide. It features Google's distinctive card-based layout, typography, elevation patterns, and interactive elements like ripple effects that will be immediately familiar to users of Google products.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Google theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.google',  // Make Google the default theme
    
    'themes' => [
        'google' => [
            'scripts' => [
                '/vendor/flasher/themes/google.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/google.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.google  # Make Google the default theme
    
    themes:
        google:
            scripts:
                - '/vendor/flasher/themes/google.min.js'
            styles:
                - '/vendor/flasher/themes/google.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { googleTheme } from '@flasher/flasher/themes';
flasher.addTheme('google', googleTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.google';

// Or use it for specific notifications
flasher.success('Operation completed successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Google styling:

{% assign successMessage = 'Operation completed successfully.' %}
{% assign errorMessage = 'An error occurred during the operation.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New updates are available.' %}

<script type="text/javascript">
    messages['#/ google types'] = [
        {
            handler: 'theme.google',
            type: 'success',
            message: '{{ successMessage }}',
            title: 'Success',
            options: { theme: 'google' },
        },
        {
            handler: 'theme.google',
            type: 'error',
            message: '{{ errorMessage }}',
            title: 'Error',
            options: { theme: 'google' },
        },
        {
            handler: 'theme.google',
            type: 'warning',
            message: '{{ warningMessage }}',
            title: 'Warning',
            options: { theme: 'google' },
        },
        {
            handler: 'theme.google',
            type: 'info',
            message: '{{ infoMessage }}',
            title: 'Information',
            options: { theme: 'google' },
        }
    ];
</script>

### PHP

```php
#/ google types

// With Google set as default theme
flash()->success('{{ successMessage }}', 'Success');
flash()->error('{{ errorMessage }}', 'Error');
flash()->warning('{{ warningMessage }}', 'Warning');
flash()->info('{{ infoMessage }}', 'Information');
```

### JavaScript

```javascript
// With Google set as default theme
flasher.success('{{ successMessage }}', 'Success');
flasher.error('{{ errorMessage }}', 'Error');
flasher.warning('{{ warningMessage }}', 'Warning');
flasher.info('{{ infoMessage }}', 'Information');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Google Theme for Specific Notifications

If Google isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.google')
    ->success('This notification uses Google theme.');
```

#### JavaScript

```javascript
flasher.use('theme.google').success('This notification uses Google theme.');
```

### Custom Colors and Appearance

The Google theme uses CSS variables that can be customized to match your brand while maintaining the Material Design feel:

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

The Google theme generates notifications with the following HTML structure:

```html
<div class="fl-google fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-md-card">
        <div class="fl-content">
            <div class="fl-icon-wrapper">
                <!-- SVG icon -->
            </div>
            <div class="fl-text-content">
                <div class="fl-title">Title (if provided)</div>
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

This structure follows Material Design principles with cards, proper typography hierarchy, and interactive elements.

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

- **Title**: 16px (1rem), medium weight (500)
- **Message**: 14px (0.875rem), regular weight (400), 60% opacity for secondary text
- **Button**: 13px (0.8125rem), medium weight (500), uppercase with letterSpacing

#### Ripple Effect

The theme includes Material Design's signature "ink ripple" effect:

1. A small circle appears at the point of interaction
2. The circle rapidly expands outward
3. The effect fades out as it reaches full size

This provides visual feedback that enhances the tactile feeling of the interface.

### Dark Mode

The Google theme implements Material Design's dark theme guidelines:

- Dark surfaces (#2d2d2d)
- Light text (87% white for primary, 60% white for secondary)
- Adjusted shadows for better visibility on dark backgrounds
- Higher contrast for hover states (8% opacity instead of 4%)

### Accessibility Features

The Google theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables animations
- **Keyboard Access**: Action button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Text Alternatives**: Descriptive aria-labels for interactive elements

## <i class="fa-solid fa-browser"></i> Browser Support

The Google theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

The ripple effect and other animations may have slightly different appearances across browsers, but the core functionality works everywhere.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Google theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Material Design Elevation**: Proper shadow implementation for depth
- **Ripple Animation**: For tactile button feedback
- **CSS Animations**: With Material Design easing curves
- **Linear Progress**: For countdown visualization
- **Roboto Font**: Falls back to system fonts if unavailable
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.

For the best experience, it's recommended to include the Roboto font in your project:

```html
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
```
