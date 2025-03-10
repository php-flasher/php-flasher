---
permalink: /theme/sapphire/
title: Sapphire Theme
description: Add modern, glassmorphic notifications to your application with the Sapphire theme for PHPFlasher. Featuring a blurred backdrop effect, minimal interface, and subtle animations.
handler: theme.sapphire
data-controller: theme-sapphire
---

## <i class="fa-solid fa-gem text-blue-500"></i> Sapphire Theme

The Sapphire theme provides modern, glassmorphic notifications with a blurred backdrop effect. It features a clean, minimal design that emphasizes simplicity and contemporary aesthetics, with semi-transparent colored backgrounds and subtle animations that create a sophisticated, unobtrusive appearance.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Sapphire theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.sapphire',  // Make Sapphire the default theme
    
    'themes' => [
        'sapphire' => [
            'scripts' => [
                '/vendor/flasher/themes/sapphire.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/sapphire.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.sapphire  # Make Sapphire the default theme
    
    themes:
        sapphire:
            scripts:
                - '/vendor/flasher/themes/sapphire.min.js'
            styles:
                - '/vendor/flasher/themes/sapphire.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { sapphireTheme } from '@flasher/flasher/themes';
flasher.addTheme('sapphire', sapphireTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.sapphire';

// Or use it for specific notifications
flasher.success('Your changes have been saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Sapphire styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'There was a problem saving your changes.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New features are available.' %}

<script type="text/javascript">
    messages['#/ sapphire types'] = [
        {
            handler: 'theme.sapphire',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'sapphire' },
        },
        {
            handler: 'theme.sapphire',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'sapphire' },
        },
        {
            handler: 'theme.sapphire',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'sapphire' },
        },
        {
            handler: 'theme.sapphire',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'sapphire' },
        }
    ];
</script>

### PHP

```php
#/ sapphire types

// With Sapphire set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Sapphire set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Sapphire Theme for Specific Notifications

If Sapphire isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.sapphire')
    ->success('This notification uses Sapphire theme.');
```

#### JavaScript

```javascript
flasher.use('theme.sapphire').success('This notification uses Sapphire theme.');
```

### Custom Colors and Appearance

The Sapphire theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --sapphire-bg-base: rgba(30, 30, 30, 0.9);    /* Base background color */
    --sapphire-text: #f0f0f0;                     /* Text color */
    --sapphire-shadow: rgba(0, 0, 0, 0.15);       /* Shadow color */
    --sapphire-border-radius: 12px;               /* Corner roundness */
    --sapphire-blur: 12px;                        /* Backdrop blur amount */
    
    /* Progress bar colors */
    --sapphire-progress-bg: rgba(255, 255, 255, 0.2);  /* Progress background */
    --sapphire-progress-fill: rgba(255, 255, 255, 0.9); /* Progress fill */
    
    /* Notification type colors */
    --sapphire-success: rgba(16, 185, 129, 0.95); /* Success color */
    --sapphire-error: rgba(239, 68, 68, 0.95);    /* Error color */
    --sapphire-warning: rgba(245, 158, 11, 0.95); /* Warning color */
    --sapphire-info: rgba(59, 130, 246, 0.95);    /* Info color */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Sapphire theme generates notifications with the following HTML structure:

```html
<div class="fl-sapphire fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <span class="fl-message">Message text</span>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

Note that unlike most themes, Sapphire intentionally omits a close button and icons for a more streamlined appearance.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Glassmorphic Design

The Sapphire theme implements the popular glassmorphism design trend with a semi-transparent background and backdrop blur that creates a frosted glass effect where:

- The notification background is semi-transparent
- Content behind the notification appears blurred
- The effect creates depth and visual interest
- The notification feels like it's floating above the content

### Minimalist Approach

Unlike many notification themes, Sapphire takes a distinctly minimalist approach:

- No close button (notifications auto-dismiss)
- No icons or visual indicators beyond color
- Clean typography with minimal styling
- Focus purely on the message content
- Subtle progress indicator

This approach reduces visual noise and creates a more elegant, unobtrusive notification experience.

### Animation Effects

The Sapphire theme features a distinctive bounce animation for a more dynamic entrance where notifications:

1. Fade in from invisible to fully visible
2. Move upward from below their final position
3. Slightly overshoot their target position before settling (bounce effect)

The animation uses a carefully tuned easing curve that enhances the natural feel of the motion.

### Color System

The theme uses a sophisticated color system:

- High transparency backgrounds (95% opacity)
- Type-specific colors that maintain a consistent visual language
- Light text (#f0f0f0) for excellent contrast on all background colors
- Semi-transparent progress indicator that works across all notification types

### Accessibility Features

The Sapphire theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables animations
- **Color Contrast**: Ensures good contrast between text and all background colors
- **RTL Support**: Complete right-to-left language support

## <i class="fa-solid fa-browser"></i> Browser Support

The Sapphire theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

For browsers that don't support backdrop-filter (like older Firefox versions), the theme gracefully degrades to using just the semi-transparent background without the blur effect.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Sapphire theme uses modern web technologies:

- **CSS Variables**: For theme customization
- **Backdrop Filter**: For the frosted glass effect
- **CSS Animations**: For the bounce entrance effect
- **CSS Transitions**: For smooth progress bar animation
- **Media Queries**: For responsive design and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.

For the best experience with the Sapphire theme, it's recommended to include the Roboto font in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
```
