# PHPFlasher Neon Theme

## Overview

The Neon theme provides elegant notifications with subtle glowing accents that evoke the gentle illumination of neon lights. It features a frosted glass background, floating illuminated indicators, and refined typography that come together to create a modern, sophisticated appearance.

![Neon Theme Preview](./images/neon-theme.png)

## Features

- **Subtle Glow Effects**: Gentle illumination based on notification type
- **Floating Indicator**: Colored dot that appears to float above the notification
- **Frosted Glass**: Semi-transparent background with backdrop blur
- **Elegant Typography**: Clean, refined text using Inter font
- **Pulsing Animation**: Subtle "breathing" effect on the glowing indicator
- **Entrance Animation**: Smooth appearance with combined movement and blur transitions
- **Progress Indicator**: Colored bar showing time remaining
- **Dark Mode Support**: Enhanced dark appearance that preserves glow effects
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { neonTheme } from '@flasher/flasher/themes';
flasher.addTheme('neon', neonTheme);

// Use the theme
flasher.use('theme.neon').success('Your changes have been saved');
flasher.use('theme.neon').error('There was a problem saving your changes');
flasher.use('theme.neon').warning('This action cannot be undone');
flasher.use('theme.neon').info('New features are available');

// Set as default theme
flasher.defaultPlugin = 'theme.neon';
```

## Customization

The Neon theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --neon-bg-light: rgba(255, 255, 255, 0.9);    /* Light mode background */
    --neon-bg-dark: rgba(15, 23, 42, 0.9);        /* Dark mode background */
    --neon-text-light: #334155;                   /* Light mode text */
    --neon-text-dark: #f1f5f9;                    /* Dark mode text */
    --neon-border-radius: 12px;                   /* Corner roundness */
    
    /* Glow colors */
    --neon-success: #10b981;                      /* Success color */
    --neon-info: #3b82f6;                         /* Info color */
    --neon-warning: #f59e0b;                      /* Warning color */
    --neon-error: #ef4444;                        /* Error color */
    
    /* Glow properties */
    --neon-glow-strength: 10px;                   /* How far the glow extends */
}
```

## Structure

The Neon theme generates notifications with the following HTML structure:

```html
<div class="fl-neon fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

The `fl-icon-box` element is created using CSS pseudo-elements rather than being part of the HTML structure.

## Animation Details

The Neon theme features two distinctive animations:

### Entrance Animation

```css
@keyframes neonEntrance {
    0% {
        opacity: 0;
        transform: translateY(-15px);
        filter: blur(3px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
        filter: blur(0);
    }
}
```

This combined animation creates a refined entrance where notifications:
1. Fade in from invisible to fully visible
2. Move downward slightly from above
3. Transition from a blurred state to sharp focus

### Glow Animation

```css
@keyframes neonGlow {
    0%, 100% {
        filter: drop-shadow(0 0 var(--neon-glow-strength) currentColor);
    }
    50% {
        filter: drop-shadow(0 0 calc(var(--neon-glow-strength) * 0.7) currentColor);
    }
}
```

This creates a subtle "breathing" effect where the glow gently pulses, becoming slightly dimmer in the middle of the animation cycle before returning to full brightness.

## Floating Indicator Design

The floating illuminated indicator is created using a combination of elements:

1. **Container**: Positioned above the notification's top edge
2. **Glow**: Applied using a filter drop-shadow with the type's color
3. **Background**: Semi-transparent circle created with ::before pseudo-element
4. **Center dot**: Solid-colored small dot created with ::after pseudo-element

This layering creates the illusion of a floating, glowing dot that serves as a visual indicator of the notification type.

## Frosted Glass Effect

The theme uses a semi-transparent background combined with backdrop-filter to create a frosted glass effect:

```css
backdrop-filter: blur(10px);
-webkit-backdrop-filter: blur(10px);
```

This creates a modern, sophisticated appearance where the notification appears to float above the page with a subtle blur applied to content behind it.

## Typography

The Neon theme prioritizes elegant typography:

- Uses the Inter font (with fallbacks) for a clean, modern look
- Medium font weight (500) for better readability without being too heavy
- Comfortable line height (1.5) for easy scanning
- Slightly larger than standard text size (15px) for better visibility

## Dark Mode

The dark mode implementation maintains the glowing aesthetic while adjusting for low-light environments:

- Dark slate semi-transparent background
- Light colored text for better contrast
- Stronger shadow for better depth perception
- Adjusted hover state for the close button

The glowing colors remain consistent between light and dark modes to maintain brand color recognition.

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables both entrance and glow animations
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Contrast**: Maintains sufficient contrast ratio between text and background
- **Visual Indicators**: Uses both color and position to signal notification type

## Browser Support

The Neon theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

For browsers that don't support backdrop-filter (like Firefox), the theme gracefully degrades to using just the semi-transparent background without the blur effect.

## Font Considerations

For the best experience with the Neon theme, it's recommended to include the Inter font in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
```

If Inter is not available, the theme falls back to the system font stack while maintaining its elegant aesthetic as much as possible.
