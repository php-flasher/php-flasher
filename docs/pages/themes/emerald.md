# PHPFlasher Emerald Theme

## Overview

The Emerald theme provides an elegant, glass-like notification style with a distinctive bounce animation and translucent background. It focuses on minimalism and modern aesthetics, featuring colored text rather than backgrounds to indicate notification types.

![Emerald Theme Preview](./images/emerald-theme.png)

## Features

- **Glass Morphism**: Semi-transparent background with backdrop blur for a frosted glass effect
- **Bounce Animation**: Distinctive bounce animation when notifications appear
- **Colored Text**: Each notification type has its own text color for subtle visual distinction
- **Clean Typography**: Uses the modern Inter font with optimized readability
- **Minimalist Design**: Omits icons and progress bars for a cleaner, more elegant look
- **Soft Shadows**: Gentle shadows that add depth without heaviness
- **Dark Mode Support**: Complete dark mode implementation with adjusted opacity and contrast
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { emeraldTheme } from '@flasher/flasher/themes';
flasher.addTheme('emerald', emeraldTheme);

// Use the theme
flasher.use('theme.emerald').success('Your changes have been saved');
flasher.use('theme.emerald').error('An error occurred while saving');
flasher.use('theme.emerald').warning('Your session will expire soon');
flasher.use('theme.emerald').info('New features have been added');

// Set as default theme
flasher.defaultPlugin = 'theme.emerald';
```

## Customization

The Emerald theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base colors */
    --emerald-bg-light: rgba(255, 255, 255, 0.9);  /* Light background */
    --emerald-bg-dark: rgba(30, 30, 30, 0.9);      /* Dark background */
    --emerald-text-light: #333333;                 /* Light mode text */
    --emerald-text-dark: rgba(255, 255, 255, 0.9); /* Dark mode text */
    --emerald-shadow: rgba(0, 0, 0, 0.1);          /* Shadow color */
    --emerald-blur: 8px;                           /* Blur amount */
    
    /* Type colors */
    --emerald-success: #16a085;                    /* Success color */
    --emerald-error: #e74c3c;                      /* Error color */
    --emerald-warning: #f39c12;                    /* Warning color */
    --emerald-info: #3498db;                       /* Info color */
}
```

## Structure

The Emerald theme generates notifications with the following HTML structure:

```html
<div class="fl-emerald fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
</div>
```

## Animation

The Emerald theme features a distinctive bounce animation that works as follows:

1. **Start**: The notification begins at 50% size and slightly below its final position
2. **Middle**: It quickly grows to 110% size and slightly above its final position
3. **End**: It settles back to 100% size at its final position

This creates a playful yet elegant "bounce" effect that draws attention without being too disruptive.

## Design Philosophy

The Emerald theme is named after its polished, refined appearance that gives notifications a gem-like quality. Its design principles include:

- **Simplicity**: Only essential elements are included
- **Elegance**: Soft blurs, shadows, and animations create a premium feel
- **Subtlety**: Colored text rather than backgrounds for a more refined look
- **Modernity**: Contemporary typography and glass-like effects
- **Focus**: Clear emphasis on the message content

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Text Sizing**: Uses relative units (rem) for text to respect user font size preferences
- **Button Labels**: Close button has descriptive aria-label for screen readers

## Technical Notes

### Backdrop Filter Support

The glass effect uses CSS `backdrop-filter` which has good but not universal browser support. In browsers without support, the theme falls back gracefully to a semi-transparent background without the blur effect.

### Font Selection

The theme specifies Inter as the preferred font, with fallback to the system font stack. To ensure optimal appearance, you may want to include Inter in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
```

## Browser Support

The Emerald theme is compatible with all modern browsers:

- Chrome 76+
- Firefox 70+
- Safari 9+
- Edge 79+
- Opera 63+

For browsers that don't support backdrop-filter, the theme gracefully degrades to a translucent background without blur.
