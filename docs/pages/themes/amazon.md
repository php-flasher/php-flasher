---
permalink: /theme/amazon/
title: Amazon Theme
description: Transform your notifications with the Amazon-inspired theme for PHPFlasher. Create clean, minimal notifications that match Amazon's design language with built-in accessibility and dark mode support.
handler: theme.amazon
data-controller: theme-amazon
---

## <i class="fa-solid fa-store"></i> Amazon Theme

The Amazon theme provides notification styling inspired by Amazon's e-commerce platform, featuring clean, minimal design with a focus on readability and accessibility.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Amazon theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.amazon',  // Make Amazon the default theme
    
    'themes' => [
        'amazon' => [
            'scripts' => [
                '/vendor/flasher/themes/amazon.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/amazon.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.amazon  # Make Amazon the default theme
    
    themes:
        amazon:
            scripts:
                - '/vendor/flasher/themes/amazon.min.js'
            styles:
                - '/vendor/flasher/themes/amazon.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { amazonTheme } from '@flasher/flasher/themes';
flasher.addTheme('amazon', amazonTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.amazon';

// Or use it for specific notifications
flasher.success('Your order has been completed successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Amazon styling:

{% assign successMessage = 'Order #12345 has been confirmed.' %}
{% assign errorMessage = 'Your payment was declined.' %}
{% assign warningMessage = 'Your subscription will expire soon.' %}
{% assign infoMessage = 'New products are available in your area.' %}

<script type="text/javascript">
    messages['#/ amazon types'] = [
        {
            handler: 'theme.amazon',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'amazon' },
        },
        {
            handler: 'theme.amazon',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'amazon' },
        },
        {
            handler: 'theme.amazon',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'amazon' },
        },
        {
            handler: 'theme.amazon',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'amazon' },
        }
    ];
</script>

### PHP

```php
#/ amazon types

// With Amazon set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Amazon set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Amazon Theme for Specific Notifications

If Amazon isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.amazon')
    ->success('This notification uses Amazon theme.');
```

#### JavaScript

```javascript
flasher.use('theme.amazon').success('This notification uses Amazon theme.');
```

### Custom Colors

The Amazon theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Amazon theme colors - Light mode */
    --amazon-success-bg: #f0fff5;       /* Success background */
    --amazon-success-border: #7fda95;   /* Success border */
    --amazon-success-icon: #007600;     /* Success icon color */
    --amazon-info-bg: #f3f9ff;          /* Info background */
    --amazon-info-border: #7fb4da;      /* Info border */
    --amazon-info-icon: #0066c0;        /* Info icon color */
    --amazon-warning-bg: #fffcf3;       /* Warning background */
    --amazon-warning-border: #ffd996;   /* Warning border */
    --amazon-warning-icon: #c45500;     /* Warning icon color */
    --amazon-error-bg: #fff5f5;         /* Error background */
    --amazon-error-border: #ff8f8f;     /* Error border */
    --amazon-error-icon: #c40000;       /* Error icon color */
    
    /* Dark mode colors */
    --amazon-success-bg-dark: #0a3317;
    --amazon-success-border-dark: #2a6e3f;
    --amazon-success-icon-dark: #7fda95;
    --amazon-info-bg-dark: #0a2940;
    --amazon-info-border-dark: #2a5d6e;
    --amazon-info-icon-dark: #7fb4da;
    --amazon-warning-bg-dark: #3d2800;
    --amazon-warning-border-dark: #6e5c2a;
    --amazon-warning-icon-dark: #ffd996;
    --amazon-error-bg-dark: #400a0a;
    --amazon-error-border-dark: #6e2a2a;
    --amazon-error-icon-dark: #ff8f8f;
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Amazon theme generates notifications with the following HTML structure:

```html
<div class="fl-amazon fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-amazon-alert">
        <div class="fl-alert-content">
            <div class="fl-icon-container">
                <!-- SVG icon -->
            </div>
            <div class="fl-text-content">
                <div class="fl-alert-title">Title</div>
                <div class="fl-alert-message">Message</div>
            </div>
        </div>
        <div class="fl-alert-actions">
            <button class="fl-close" aria-label="Close notification">
                <!-- Close icon -->
            </button>
        </div>
    </div>
</div>
```

This structure provides proper semantic markup and accessibility attributes for screen readers and assistive technologies.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Dark Mode

The Amazon theme automatically adapts to system dark mode preferences without additional configuration using the `prefers-color-scheme` media query.

### Accessibility Features

The Amazon theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **High Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Screen Reader Support**: Proper labeling of interactive elements

## <i class="fa-solid fa-browser"></i> Browser Support

The Amazon theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Amazon theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Flexbox Layout**: For responsive and flexible notification structure
- **SVG Icons**: For resolution-independent, lightweight icons
- **Media Queries**: For responsive design, dark mode, and reduced motion support
- **ARIA Attributes**: For accessibility and screen reader support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
