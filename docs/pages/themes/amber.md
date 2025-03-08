# PHPFlasher Amber Theme

## Overview

The Amber theme is a modern, elegant notification style with refined aesthetics that focuses on clean design and readability. It offers a minimalist approach while maintaining visual appeal with subtle animations and transitions.

![Amber Theme Preview](./images/amber-theme.png)

## Features

- **Modern Design**: Clean, minimalist styling with optimal readability
- **Type-Specific Icons**: Each notification type (success, error, warning, info) has its own icon
- **Progress Indicator**: Shows the time remaining before auto-dismiss
- **Smooth Animation**: Subtle entrance animation for a polished feel
- **Dark Mode Support**: Complete dark mode implementation with optimized colors
- **RTL Support**: Full right-to-left language support
- **Accessibility**: ARIA roles, reduced motion support, and keyboard accessibility

## Usage

```typescript
// Import the theme (if not auto-registered)
import { amberTheme } from '@flasher/flasher/themes';
flasher.addTheme('amber', amberTheme);

// Use the theme
flasher.use('theme.amber').success('Your changes have been saved');
flasher.use('theme.amber').error('An error occurred while saving changes');
flasher.use('theme.amber').warning('Your session will expire in 5 minutes');
flasher.use('theme.amber').info('New features have been added');

// Set as default theme
flasher.defaultPlugin = 'theme.amber';
```

## Customization

The Amber theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --amber-bg-light: #ffffff;          /* Light mode background */
    --amber-bg-dark: #1e293b;           /* Dark mode background */
    --amber-text-light: #4b5563;        /* Light mode text */
    --amber-text-dark: #f1f5f9;         /* Dark mode text */
    --amber-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); /* Light mode shadow */
    --amber-border-radius: 0.4rem;      /* Border radius */

    /* Type-specific colors */
    --amber-success: #10b981;           /* Success color */
    --amber-info: #3b82f6;              /* Info color */
    --amber-warning: #f59e0b;           /* Warning color */
    --amber-error: #ef4444;             /* Error color */
}
```

## Structure

The Amber theme generates notifications with the following HTML structure:

```html
<div class="fl-amber fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-icon"></div>
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

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Button Labels**: Close button has descriptive aria-label for screen readers

## Differences from Default Theme

The Amber theme differs from the default theme in several ways:

1. **More Minimal**: Cleaner design with less ornamentation
2. **Subtle Shadows**: Uses softer box shadows for a modern look
3. **Smaller Icon**: Uses a more compact icon size
4. **No Title**: Focuses solely on the message content for simplicity
5. **Different Animation**: Uses a top-down entrance animation
6. **Colored Close Button**: Close button is colored based on notification type

## Browser Support

The Amber theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Implementation Details

The Amber theme uses:

- **CSS Variables**: For theme customization
- **Flexbox**: For layout structure
- **CSS Animations**: For entrance effects
- **Media Queries**: For responsive design and accessibility
- **Core Icons**: Uses the PHPFlasher core icon system
