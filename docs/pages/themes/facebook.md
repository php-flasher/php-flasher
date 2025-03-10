---
permalink: /theme/facebook/
title: Facebook Theme
description: Add Facebook-style notifications to your application with the Facebook theme for PHPFlasher. Featuring familiar notification cards, circular icons, and Facebook's signature design elements.
handler: theme.facebook
data-controller: theme-facebook
---

## <i class="fa-brands fa-facebook"></i> Facebook Theme

The Facebook theme replicates the familiar notification style from Facebook's interface, providing a user experience that billions of people worldwide will instantly recognize. It features Facebook's signature look and feel, including rounded cards, circular icons, and the platform's distinctive typography and color scheme.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Facebook theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.facebook',  // Make Facebook the default theme
    
    'themes' => [
        'facebook' => [
            'scripts' => [
                '/vendor/flasher/themes/facebook.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/facebook.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.facebook  # Make Facebook the default theme
    
    themes:
        facebook:
            scripts:
                - '/vendor/flasher/themes/facebook.min.js'
            styles:
                - '/vendor/flasher/themes/facebook.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { facebookTheme } from '@flasher/flasher/themes';
flasher.addTheme('facebook', facebookTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.facebook';

// Or use it for specific notifications
flasher.success('Your post was published successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Facebook styling:

{% assign successMessage = 'Your post was published successfully.' %}
{% assign errorMessage = 'There was a problem uploading your photo.' %}
{% assign warningMessage = 'Your account is approaching storage limits.' %}
{% assign infoMessage = '3 people reacted to your comment.' %}

<script type="text/javascript">
    messages['#/ facebook types'] = [
        {
            handler: 'theme.facebook',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'facebook' },
        },
        {
            handler: 'theme.facebook',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'facebook' },
        },
        {
            handler: 'theme.facebook',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'facebook' },
        },
        {
            handler: 'theme.facebook',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'facebook' },
        }
    ];
</script>

### PHP

```php
#/ facebook types

// With Facebook set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Facebook set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Facebook Theme for Specific Notifications

If Facebook isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.facebook')
    ->success('This notification uses Facebook theme.');
```

#### JavaScript

```javascript
flasher.use('theme.facebook').success('This notification uses Facebook theme.');
```

### Adding a Timestamp

You can add a timestamp to your Facebook-style notification:

#### PHP

```php
flash()
    ->use('theme.facebook')
    ->success('Your post was published successfully.');
```

#### JavaScript

```javascript
flasher.use('theme.facebook')
    .success('Your post was published successfully');
```

If no timestamp is provided, the current time will be used automatically.

### Custom Colors and Appearance

The Facebook theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base colors */
    --fb-bg-light: #ffffff;                  /* Light mode background */
    --fb-bg-dark: #242526;                   /* Dark mode background */
    --fb-text-light: #050505;                /* Light mode primary text */
    --fb-text-secondary-light: #65676b;      /* Light mode secondary text */
    --fb-text-dark: #e4e6eb;                 /* Dark mode primary text */
    --fb-text-secondary-dark: #b0b3b8;       /* Dark mode secondary text */
    --fb-hover-light: #f0f2f5;               /* Light mode hover state */
    --fb-hover-dark: #3a3b3c;                /* Dark mode hover state */
    
    /* Type colors */
    --fb-success: #31a24c;                   /* Success color */
    --fb-info: #1876f2;                      /* Info color (Facebook blue) */
    --fb-warning: #f7b928;                   /* Warning color */
    --fb-error: #e41e3f;                     /* Error color */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Facebook theme generates notifications with the following HTML structure:

```html
<div class="fl-facebook fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-fb-notification">
        <div class="fl-icon-container">
            <div class="fl-fb-icon fl-fb-icon-[type]">
                <!-- SVG icon -->
            </div>
        </div>
        <div class="fl-content">
            <div class="fl-message">Message text</div>
            <div class="fl-meta">
                <span class="fl-time">15:43</span>
            </div>
        </div>
        <div class="fl-actions">
            <button class="fl-button fl-close" aria-label="Close [type] message">
                <div class="fl-button-icon">
                    <!-- Close SVG icon -->
                </div>
            </button>
        </div>
    </div>
</div>
```

This structure closely mimics Facebook's notification layout, including the circular icons, message content, timestamp, and close button.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Facebook-Style Design

The Facebook theme accurately recreates Facebook's notification appearance with:

- Rounded notification cards with subtle shadows
- Circular colored icons for each notification type
- Timestamp display showing when the notification was created
- Interactive close button with hover effects
- Facebook's signature typography

### Dark Mode

The theme automatically adapts to system dark mode preferences without additional configuration, switching to Facebook's dark theme colors for a consistent experience.

### Accessibility Features

The Facebook theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: Maintains Facebook's visual identity while ensuring readability
- **Button Labels**: Close button has descriptive aria-label for screen readers

## <i class="fa-solid fa-browser"></i> Browser Support

The Facebook theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Facebook theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Facebook's Font Stack**: For authentic typography
- **SVG Icons**: For high-quality, resolution-independent icons
- **CSS Animations**: For subtle entrance effects
- **CSS Box Shadows**: For depth and dimension
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
