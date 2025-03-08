# PHPFlasher Onyx Theme

## Overview

The Onyx theme provides modern, floating notifications with a clean design and subtle accent elements. It features elegant shadows, colored corner dots indicating notification type, and smooth animations to create a sophisticated, contemporary appearance that integrates well with modern interfaces.

![Onyx Theme Preview](./images/onyx-theme.png)

## Features

- **Floating Appearance**: Clean cards with elegant shadows for a floating effect
- **Accent Dots**: Small colored dots in the corners indicate notification type
- **Generous Rounded Corners**: Large border radius (1rem) for a contemporary look
- **Smooth Animation**: Combined movement and blur transitions for refined entrance
- **Minimal Design**: No large icons or visual elements to maintain focus on content
- **Progress Indicator**: Colored bar showing time remaining
- **Type-Specific Accents**: Each notification type has its own color scheme
- **Dark Mode Support**: Enhanced dark appearance with adjusted shadows and colors
- **RTL Support**: Full right-to-left language support with proper dot positioning

## Usage

```typescript
// Import the theme (if not auto-registered)
import { onyxTheme } from '@flasher/flasher/themes';
flasher.addTheme('onyx', onyxTheme);

// Use the theme
flasher.use('theme.onyx').success('Your changes have been saved');
flasher.use('theme.onyx').error('There was a problem saving your changes');
flasher.use('theme.onyx').warning('This action cannot be undone');
flasher.use('theme.onyx').info('New features are available');

// Set as default theme
flasher.defaultPlugin = 'theme.onyx';
```

## Customization

The Onyx theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --onyx-bg-light: #ffffff;                    /* Light mode background */
    --onyx-bg-dark: #1e1e1e;                     /* Dark mode background */
    --onyx-text-light: #333333;                  /* Light mode text */
    --onyx-text-dark: #f5f5f5;                   /* Dark mode text */
    --onyx-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); /* Light mode shadow */
    --onyx-border-radius: 1rem;                  /* Corner roundness */
    
    /* Accent colors */
    --onyx-success: #10b981;                     /* Success color */
    --onyx-info: #3b82f6;                        /* Info color */
    --onyx-warning: #f59e0b;                     /* Warning color */
    --onyx-error: #ef4444;                       /* Error color */
}
```

## Structure

The Onyx theme generates notifications with the following HTML structure:

```html
<div class="fl-onyx fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
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

The accent dots are created using CSS pseudo-elements (`::before` and `::after`) rather than being part of the HTML structure.

## Animation Details

The Onyx theme features a sophisticated entrance animation that combines multiple effects:

```css
@keyframes onyxIn {
    0% {
        opacity: 0;
        transform: translateY(15px);
        filter: blur(3px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }
}
```

This combined animation creates a refined appearance where notifications:
1. Fade in from invisible to fully visible
2. Move upward slightly from below their final position
3. Transition from a blurred state to sharp focus

The animation uses a carefully crafted easing curve (`cubic-bezier(0.16, 1, 0.3, 1)`) for a natural, refined movement.

## Accent Dots Design

One of the distinctive features of the Onyx theme is its use of subtle accent dots in the corners:

1. **Top-left dot**: Positioned 10px from the top and left edges
2. **Bottom-right dot**: Positioned 10px from the bottom and right edges
3. **Small size**: Each dot is just 6px in diameter
4. **Type-specific colors**: The dots match the color associated with the notification type

These small visual elements provide a subtle but clear indication of the notification type without requiring large icons or colored backgrounds.

## Typography

The Onyx theme features clean, modern typography:

- Regular weight (400) for a light, contemporary feel
- Comfortable line height (1.5) for easy reading
- Slight letter spacing (0.01rem) for improved legibility
- Modest font size (0.925rem or approximately 14.8px at default size)

## Dark Mode

The dark mode implementation maintains the sophisticated aesthetic while adjusting for low-light environments:

- Dark background (#1e1e1e)
- Light text color (#f5f5f5)
- Deeper shadow for enhanced depth perception
- Adjusted hover state for the close button using white opacity

The accent dot colors remain consistent between light and dark modes to maintain brand color recognition.

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables entrance animation
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Indicators**: Uses colored dots to indicate type without relying solely on color for meaning
- **Adequate Contrast**: Ensures good contrast between text and background in both light and dark modes

## Design Philosophy

The Onyx theme embodies several design principles:

1. **Elegance**: Clean, sophisticated appearance with subtle details
2. **Minimalism**: Only essential elements are included, with no icons or extraneous components
3. **Focus**: The clean design keeps attention on the message content
4. **Refinement**: Thoughtful attention to details like animation timing and corner dots 
5. **Consistency**: Each notification type follows the same pattern with its own accent color

## Browser Support

The Onyx theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

No special polyfills or fallbacks are required as the theme uses standard CSS features that are well-supported across browsers.
