---
permalink: /theme/flasher/
title: Flasher Theme
description: Explore the default notification theme for PHPFlasher featuring a clean design with distinctive colored borders, clear type indicators, and comprehensive accessibility support.
handler: theme.flasher
data-controller: theme-flasher
---

## <i class="fa-solid fa-bolt"></i> Flasher Theme

The Flasher theme is the default notification theme for PHPFlasher. It provides a classic, clean design with a distinctive colored left border that visually indicates the notification type. This theme balances visual clarity with simplicity, making it suitable for a wide range of applications.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

As the default theme for PHPFlasher, the Flasher theme is automatically available without any additional configuration. However, you can explicitly set it as your default theme:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'flasher',  // Use the default Flasher theme
    
    // Other configuration options...
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: flasher  # Use the default Flasher theme
    
    # Other configuration options...
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// The Flasher theme is available by default
// You can use it directly:
flasher.success('Operation completed successfully');

// Or explicitly specify it:
flasher.defaultPlugin = 'flasher';
```

## <i class="fa-solid fa-palette"></i> Notification Types

Use standard PHPFlasher methods to create notifications with the default Flasher styling:

{% assign successMessage = 'Operation completed successfully.' %}
{% assign errorMessage = 'An error occurred during the operation.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New updates are available.' %}

<script type="text/javascript">
    messages['#/ flasher types'] = [
        {
            handler: 'flasher',
            type: 'success',
            message: '{{ successMessage }}',
            title: 'Success'
        },
        {
            handler: 'flasher',
            type: 'error',
            message: '{{ errorMessage }}',
            title: 'Error'
        },
        {
            handler: 'flasher',
            type: 'warning',
            message: '{{ warningMessage }}',
            title: 'Warning'
        },
        {
            handler: 'flasher',
            type: 'info',
            message: '{{ infoMessage }}',
            title: 'Information'
        }
    ];
</script>

### PHP

```php
#/ flasher types

// With Flasher as default theme
flash()->success('{{ successMessage }}', 'Success');
flash()->error('{{ errorMessage }}', 'Error');
flash()->warning('{{ warningMessage }}', 'Warning');
flash()->info('{{ infoMessage }}', 'Information');
```

### JavaScript

```javascript
// With Flasher as default theme
flasher.success('{{ successMessage }}', 'Success');
flasher.error('{{ errorMessage }}', 'Error');
flasher.warning('{{ warningMessage }}', 'Warning');
flasher.info('{{ infoMessage }}', 'Information');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Flasher Theme for Specific Notifications

If another theme is set as your default, you can use the Flasher theme for specific notifications:

#### PHP

```php
flash()
    ->use('flasher')
    ->success('This notification uses the default Flasher theme.');
```

#### JavaScript

```javascript
flasher.use('flasher').success('This notification uses the default Flasher theme.');
```

### Custom Colors and Appearance

The Flasher theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base colors */
    --fl-bg-light: #ffffff;            /* Light mode background */
    --fl-bg-dark: rgb(15, 23, 42);     /* Dark mode background */
    --fl-text-light: rgb(75, 85, 99);  /* Light mode text */
    --fl-text-dark: #ffffff;           /* Dark mode text */
    
    /* Type colors */
    --fl-success: #10b981;             /* Success color */
    --fl-info: #3b82f6;                /* Info color */
    --fl-warning: #f59e0b;             /* Warning color */
    --fl-error: #ef4444;               /* Error color */
    
    /* Legacy support */
    --background-color: var(--fl-bg-light);
    --text-color: var(--fl-text-light);
    --dark-background-color: var(--fl-bg-dark);
    --dark-text-color: var(--fl-text-dark);
    --success-color: var(--fl-success);
    --info-color: var(--fl-info);
    --warning-color: var(--fl-warning);
    --error-color: var(--fl-error);
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Flasher theme generates notifications with the following HTML structure:

```html
<div class="fl-flasher fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-icon"></div>
        <div>
            <strong class="fl-title">Title text</strong>
            <span class="fl-message">Message text</span>
        </div>
        <button class="fl-close" aria-label="Close [type] message">&times;</button>
    </div>
    <span class="fl-progress-bar">
        <span class="fl-progress"></span>
    </span>
</div>
```

This structure provides a clear hierarchy with a colored left border, icon, title, message, close button, and progress bar.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Visual Characteristics

- **Colored Border**: Thick, colored left border that visually identifies the notification type
- **Type-Specific Icons**: Each notification type has its own distinctive icon
- **Title & Message Support**: Allows for both a title and detailed message
- **Progress Bar**: Shows the time remaining before auto-dismiss
- **Animation**: Smooth slide-in from the left with a subtle hover effect

### Design Philosophy

As the default theme for PHPFlasher, the Flasher theme is designed with these principles:

1. **Clarity**: The colored left border makes it immediately clear what type of notification is being shown
2. **Versatility**: The clean design fits well in a wide range of applications and design systems
3. **Accessibility**: High contrast, clear typography, and semantic HTML ensure notifications are accessible
4. **Familiarity**: The design follows common notification patterns that users will find intuitive

### Dark Mode

The theme automatically adapts to system dark mode preferences without additional configuration, with optimized colors for dark backgrounds.

### Accessibility Features

The Flasher theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **RTL Support**: Full right-to-left language support with appropriately mirrored layout

## <i class="fa-solid fa-browser"></i> Browser Support

The Flasher theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

## <i class="fa-solid fa-gears"></i> Implementation Details

The Flasher theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **Flexbox Layout**: For responsive and flexible notification structure
- **CSS Animations**: For entrance and hover effects
- **Progress Bar**: Shows countdown until notification dismissal
- **Media Queries**: For responsive design, dark mode, and reduced motion support
- **SCSS Mixins**: For shared functionality across PHPFlasher themes

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
