# PHPFlasher Crystal Theme

## Overview

The Crystal theme provides an elegant, clean notification style with subtle animations and a focus on simplicity. It features a monochromatic design with type-specific colored text and a gentle pulsing shadow effect on hover.

![Crystal Theme Preview](./images/crystal-theme.png)

## Features

- **Clean Design**: Minimal, white background that lets the content shine
- **Colored Text**: Each notification type has its own text color for easy identification
- **Animated Shadows**: Gentle pulsing shadow effect when hovering over notifications
- **Smooth Entrance**: Subtle slide-in animation when notifications appear
- **Progress Indicator**: Shows the time remaining before auto-dismiss
- **Dark Mode Support**: Complete dark mode implementation with adjusted colors
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { crystalTheme } from '@flasher/flasher/themes';
flasher.addTheme('crystal', crystalTheme);

// Use the theme
flasher.use('theme.crystal').success('Document saved successfully');
flasher.use('theme.crystal').error('An error occurred while saving');
flasher.use('theme.crystal').warning('Your session will expire in 5 minutes');
flasher.use('theme.crystal').info('New features have been added');

// Set as default theme
flasher.defaultPlugin = 'theme.crystal';
```

## Customization

The Crystal theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --crystal-bg-light: #ffffff;                  /* Light mode background */
    --crystal-bg-dark: rgba(30, 30, 30, 0.95);    /* Dark mode background */
    --crystal-text-light: #2c3e50;                /* Light mode text */
    --crystal-text-dark: rgba(255, 255, 255, 0.95); /* Dark mode text */
    --crystal-shadow: rgba(0, 0, 0, 0.08);        /* Light mode shadow */
    --crystal-shadow-dark: rgba(0, 0, 0, 0.25);   /* Dark mode shadow */
    
    /* Type colors (uses default PHPFlasher colors) */
    --fl-success: #10b981;                        /* Success color */
    --fl-info: #3b82f6;                           /* Info color */
    --fl-warning: #f59e0b;                        /* Warning color */
    --fl-error: #ef4444;                          /* Error color */
}
```

## Structure

The Crystal theme generates notifications with the following HTML structure:

```html
<div class="fl-crystal fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-text">
            <p class="fl-message">Message text</p>
        </div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

## Animations

The Crystal theme features two distinct animations:

1. **Entrance Animation**: A smooth slide-in from above with a fade-in effect
2. **Hover Animation**: A gentle pulsing shadow that creates a subtle "breathing" effect

The hover animation is disabled in dark mode and for users who prefer reduced motion, replaced with a static enhanced shadow effect.

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables animations
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Contrast**: High contrast between text and background for readability
- **Button Labels**: Close button has descriptive aria-label for screen readers

## Design Philosophy

The Crystal theme embodies clarity and simplicity. Rather than using colored backgrounds or borders, it employs colored text to indicate notification types. This creates a cleaner, more sophisticated appearance while still providing clear visual cues about the notification's nature.

The theme's name "Crystal" reflects its clean, transparent design and the subtle light effects created by its animations.

## Browser Support

The Crystal theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Implementation Notes

- Uses CSS transitions for smooth hover effects
- Employs keyframe animations for entrance and pulsing shadow
- Uses absolute positioning for the close button to maintain consistent layout
- Provides comprehensive RTL support for international applications
- Implements different behavior in dark mode for optimal visibility
