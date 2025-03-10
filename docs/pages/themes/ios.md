---
permalink: /theme/ios/
title: iOS Theme
description: Add Apple iOS-style notifications to your application with the iOS theme for PHPFlasher. Featuring frosted glass effects, app icons, and animations that mimic native iOS notifications.
handler: theme.ios
data-controller: theme-ios
---

## <i class="fa-brands fa-apple"></i> iOS Theme

The iOS theme provides notifications styled after Apple's iOS notification system, creating a familiar experience for users of iPhones and iPads. It features Apple's distinctive frosted glass effect, app icon style, and subtle animations that mimic native iOS notifications.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the iOS theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.ios',  // Make iOS the default theme
    
    'themes' => [
        'ios' => [
            'scripts' => [
                '/vendor/flasher/themes/ios.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/ios.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.ios  # Make iOS the default theme
    
    themes:
        ios:
            scripts:
                - '/vendor/flasher/themes/ios.min.js'
            styles:
                - '/vendor/flasher/themes/ios.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { iosTheme } from '@flasher/flasher/themes';
flasher.addTheme('ios', iosTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.ios';

// Or use it for specific notifications
flasher.success('Your photo was uploaded successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with iOS styling:

{% assign successMessage = 'Your photo was uploaded successfully.' %}
{% assign errorMessage = 'Unable to connect to server.' %}
{% assign warningMessage = 'Low storage space on your device.' %}
{% assign infoMessage = 'New software update available.' %}

<script type="text/javascript">
    messages['#/ ios types'] = [
        {
            handler: 'theme.ios',
            type: 'success',
            message: '{{ successMessage }}',
            title: 'Photos',
            options: { theme: 'ios' },
        },
        {
            handler: 'theme.ios',
            type: 'error',
            message: '{{ errorMessage }}',
            title: 'Settings',
            options: { theme: 'ios' },
        },
        {
            handler: 'theme.ios',
            type: 'warning',
            message: '{{ warningMessage }}',
            title: 'Storage',
            options: { theme: 'ios' },
        },
        {
            handler: 'theme.ios',
            type: 'info',
            message: '{{ infoMessage }}',
            title: 'App Store',
            options: { theme: 'ios' },
        }
    ];
</script>

### PHP

```php
#/ ios types

// With iOS set as default theme
flash()->success('{{ successMessage }}', 'Photos');
flash()->error('{{ errorMessage }}', 'Settings');
flash()->warning('{{ warningMessage }}', 'Storage');
flash()->info('{{ infoMessage }}', 'App Store');
```

### JavaScript

```javascript
// With iOS set as default theme
flasher.success('{{ successMessage }}', 'Photos');
flasher.error('{{ errorMessage }}', 'Settings');
flasher.warning('{{ warningMessage }}', 'Storage');
flasher.info('{{ infoMessage }}', 'App Store');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using iOS Theme for Specific Notifications

If iOS isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.ios')
    ->success('This notification uses iOS theme.', 'Photos');
```

#### JavaScript

```javascript
flasher.use('theme.ios').success('This notification uses iOS theme.', 'Photos');
```

### Custom Colors and Appearance

The iOS theme uses CSS variables that can be customized to match your brand while maintaining the iOS look:

```css
:root {
    /* Base appearance */
    --ios-bg-light: rgba(255, 255, 255, 0.85);  /* Light mode background */
    --ios-bg-dark: rgba(30, 30, 30, 0.85);      /* Dark mode background */
    --ios-text-light: #000000;                  /* Light mode text */
    --ios-text-secondary-light: #6e6e6e;        /* Light mode secondary text */
    --ios-text-dark: #ffffff;                   /* Dark mode text */
    --ios-text-secondary-dark: #a0a0a0;         /* Dark mode secondary text */
    --ios-border-radius: 13px;                  /* Corner radius */
    --ios-blur: 30px;                           /* Backdrop blur amount */
    
    /* Type colors - based on iOS system colors */
    --ios-success: #34c759;                     /* iOS green */
    --ios-info: #007aff;                        /* iOS blue */
    --ios-warning: #ff9500;                     /* iOS orange */
    --ios-error: #ff3b30;                       /* iOS red */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The iOS theme generates notifications with the following HTML structure:

```html
<div class="fl-ios fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-ios-notification">
        <div class="fl-header">
            <div class="fl-app-icon">
                <!-- SVG icon -->
            </div>
            <div class="fl-app-info">
                <div class="fl-app-name">App Name/Title</div>
                <div class="fl-time">2025-03-10 00:14:11</div>
            </div>
        </div>
        <div class="fl-content">
            <div class="fl-message">Message text</div>
        </div>
        <button class="fl-close" aria-label="Close [type] message">
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>
```

This structure mimics the iOS notification layout, including the app icon, app name, current time, and message content.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### iOS-Specific Design Elements

#### Frosted Glass Effect

The iOS theme uses `backdrop-filter: blur()` to create Apple's signature frosted glass effect. This creates a semi-transparent background that blurs content behind the notification.

#### App Icon

The app icon follows iOS design principles:
- Square with slightly rounded corners (5px radius)
- Colored background based on notification type
- White icon centered within the square

#### Real-Time Timestamp

The theme automatically displays the current time in the iOS format (HH:MM), just like native iOS notifications.

#### Smooth Animations

The iOS theme features two carefully crafted animations:

1. **Entrance Animation**: Slides in from above with a subtle scaling effect
2. **Content Expansion**: The content area expands with a slight delay after the header appears

These animations mimic the iOS notification animation style with a quick start and gentle end.

### Dark Mode

The theme automatically adapts to system dark mode preferences, switching to the iOS dark appearance:
- Dark semi-transparent background
- Light text
- Adjusted shadows for better visibility
- Lighter close button background

### Accessibility Features

The iOS theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables animations
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: Maintains proper contrast ratios in both light and dark modes
- **Mobile Optimization**: Responsive design that adjusts for small screens

## <i class="fa-solid fa-browser"></i> Browser Support

The iOS theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

For browsers that don't support backdrop-filter, the theme gracefully degrades to using just the semi-transparent background without blur.

## <i class="fa-solid fa-gears"></i> Implementation Details

The iOS theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Backdrop Filter**: For the frosted glass effect
- **CSS Animations**: For entrance and content expansion effects
- **San Francisco Font**: Uses Apple's system font stack with appropriate fallbacks
- **Real-Time Timestamps**: Automatically displays current time in iOS format
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.

**Note:** The title parameter is used as the "app name" in the notification. If no title is provided, it defaults to "PHPFlasher".
