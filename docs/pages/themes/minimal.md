# PHPFlasher Minimal Theme

## Overview

The Minimal theme provides an ultra-clean, distraction-free notification design that prioritizes simplicity and unobtrusiveness. With its compact dimensions, subtle visual styling, and reduced visual elements, this theme is perfect for applications where notifications should provide information without competing for attention with the main interface.

![Minimal Theme Preview](./images/minimal-theme.png)

## Features

- **Ultra-Clean Design**: Stripped down to only essential elements
- **Translucent Background**: Semi-transparent with subtle backdrop blur
- **Compact Size**: Smaller footprint with comfortable spacing
- **Small Dot Indicator**: Uses a small colored dot instead of large icons
- **System Fonts**: Uses the system font stack for optimal readability
- **Thin Progress Bar**: Nearly invisible 2px progress indicator
- **Quick Animation**: Brief, subtle entrance animation
- **Minimal Shadows**: Very light shadows for just a hint of depth
- **Dark Mode Support**: Refined dark appearance with adjusted opacity
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { minimalTheme } from '@flasher/flasher/themes';
flasher.addTheme('minimal', minimalTheme);

// Use the theme
flasher.use('theme.minimal').success('Changes saved');
flasher.use('theme.minimal').error('Connection lost');
flasher.use('theme.minimal').warning('Low disk space');
flasher.use('theme.minimal').info('Updates available');

// Set as default theme
flasher.defaultPlugin = 'theme.minimal';
```

## Customization

The Minimal theme uses CSS variables that can be customized:

```css
:root {
    /* Base appearance */
    --minimal-bg-light: rgba(255, 255, 255, 0.8);  /* Light mode background */
    --minimal-bg-dark: rgba(25, 25, 25, 0.8);      /* Dark mode background */
    --minimal-text-light: #333333;                 /* Light mode text */
    --minimal-text-dark: #f5f5f5;                  /* Dark mode text */
    --minimal-border-radius: 6px;                  /* Corner radius */
    
    /* Type colors */
    --minimal-success: rgba(34, 197, 94, 0.9);     /* Success color */
    --minimal-info: rgba(14, 165, 233, 0.9);       /* Info color */
    --minimal-warning: rgba(245, 158, 11, 0.9);    /* Warning color */
    --minimal-error: rgba(239, 68, 68, 0.9);       /* Error color */
}
```

## Structure

The Minimal theme generates notifications with the following HTML structure:

```html
<div class="fl-minimal fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

Note: The HTML includes the class `fl-dot`, but this element is not present in the rendered structure (this appears to be a small inconsistency in the theme).

## Design Philosophy

The Minimal theme embodies several key design principles:

1. **Reduction**: Eliminating all non-essential visual elements
2. **Unobtrusiveness**: Staying out of the way while delivering information
3. **Clarity**: Maintaining excellent readability with system fonts
4. **Subtlety**: Using transparency, small indicators, and minimal animation
5. **Consistency**: Applying the same minimal approach to all aspects

The theme deliberately avoids large icons, bold colors, or pronounced animations that might distract users from their primary tasks. The small colored dot provides just enough visual indication of the notification type without overwhelming the interface.

## Visual Characteristics

### Frosted Glass Effect

The theme uses a semi-transparent background (80% opacity) with an 8px backdrop blur, creating a subtle "frosted glass" effect that lets the underlying content partially show through.

### System Font Stack

```css
font-family: -apple-system, BlinkMacSystemFont, var(--fl-font), sans-serif;
```

This stack uses the system UI font of the user's device (San Francisco on Apple devices, Segoe UI on Windows, etc.), ensuring that notifications look native to the platform.

### Size and Space

- **Max Width**: 320px
- **Padding**: 0.75rem 1rem (12px 16px at default font size)
- **Text Size**: 0.875rem (14px at default font size)
- **Dot Size**: 8px diameter

### Animation

The entrance animation is intentionally brief (0.2s) and subtle:

```css
@keyframes minimalIn {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Indications**: Uses color dots to indicate type without relying solely on color
- **System Fonts**: Improved readability through native font rendering
- **Adequate Contrast**: Maintains good contrast ratio between text and background

## Dark Mode

The dark mode implementation maintains the minimal aesthetic while ensuring readability:

- Dark semi-transparent background (rgba(25, 25, 25, 0.8))
- Light text color (#f5f5f5)
- Slightly stronger shadows
- Subtle white border (10% opacity)

The colors of the dot indicators remain the same in both light and dark modes to maintain consistency.

## Browser Compatibility

The Minimal theme is compatible with all modern browsers. For the backdrop blur effect:
- Full support: Chrome 76+, Safari 9+, Edge 17+
- No backdrop blur: Firefox (falls back gracefully to semi-transparent background)

## Performance Considerations

The theme is designed for optimal performance:
- Uses `will-change: transform, opacity` to optimize animations
- Minimal DOM structure reduces rendering complexity
- Short animations minimize computation
- No complex gradients or heavy visual effects
