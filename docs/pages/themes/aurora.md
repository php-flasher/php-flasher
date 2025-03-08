# PHPFlasher Aurora Theme

## Overview

The Aurora theme provides an elegant, glass-like notification style with translucent backgrounds, subtle gradients, and backdrop blur effects. It offers a modern, refined aesthetic inspired by contemporary UI design trends like Apple's glass morphism.

![Aurora Theme Preview](./images/aurora-theme.png)

## Features

- **Glass Morphism**: Semi-transparent backgrounds with backdrop blur for a frosted glass effect
- **Subtle Gradients**: Type-specific color gradients that elegantly indicate notification type
- **Soft Edges**: Generous border radius for a friendly, modern look
- **Minimalist Design**: Focuses on content by omitting icons and unnecessary UI elements
- **Smooth Animation**: Gentle fade-in with subtle scaling for a refined entrance
- **Progress Indicator**: Understated progress bar that shows remaining time
- **Dark Mode Support**: Beautiful dark mode implementation with adjusted colors and contrast
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { auroraTheme } from '@flasher/flasher/themes';
flasher.addTheme('aurora', auroraTheme);

// Use the theme
flasher.use('theme.aurora').success('Your profile has been updated');
flasher.use('theme.aurora').error('Please check your connection');
flasher.use('theme.aurora').warning('Your session will expire soon');
flasher.use('theme.aurora').info('New feature available');

// Set as default theme
flasher.defaultPlugin = 'theme.aurora';
```

## Customization

The Aurora theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Base appearance */
    --aurora-bg-light: rgba(255, 255, 255, 0.95);  /* Light background */
    --aurora-bg-dark: rgba(20, 20, 28, 0.92);      /* Dark background */
    --aurora-text-light: #1e293b;                  /* Light mode text */
    --aurora-text-dark: #f8fafc;                   /* Dark mode text */
    --aurora-border-radius: 16px;                  /* Corner radius */
    --aurora-blur: 15px;                           /* Blur amount */
    
    /* Type-specific colors */
    --aurora-success: #10b981;                     /* Success color */
    --aurora-info: #3b82f6;                        /* Info color */
    --aurora-warning: #f59e0b;                     /* Warning color */
    --aurora-error: #ef4444;                       /* Error color */
    
    /* Gradient colors can also be customized */
    --aurora-success-gradient: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.2) 100%);
}
```

## Structure

The Aurora theme generates notifications with the following HTML structure:

```html
<div class="fl-aurora fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
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
- **Color Contrast**: Maintains proper contrast even with translucent backgrounds
- **Button Labels**: Close button has descriptive aria-label for screen readers

## Technical Details

### Backdrop Filter Support

The Aurora theme uses CSS `backdrop-filter` to create its signature glass effect. While this property has good browser support, you should be aware of a few considerations:

- **Browser Compatibility**: Supported in most modern browsers
- **Performance**: Backdrop filters can be GPU-intensive on older devices
- **Fallback**: On browsers without backdrop-filter support, notifications still look good with just the translucent background

### Animation Technique

The entrance animation combines three effects for a refined appearance:

1. **Opacity**: Fade in from transparent to visible
2. **Translation**: Slight movement from above
3. **Scale**: Subtle growth from slightly smaller to full size

This combination creates a more organic, sophisticated appearance than simple fades or slides.

### CSS Implementation Notes

- Uses `::before` pseudo-element for gradient overlays
- Applies different gradients based on notification type
- Leverages CSS custom properties for easy theming
- Implements proper RTL support with direction adjustments
- Provides complete dark mode styling

## Browser Support

The Aurora theme is compatible with all modern browsers that support CSS variables and backdrop filters:

- Chrome 76+
- Firefox 70+
- Safari 9+
- Edge 17+
- Opera 64+

For browsers that don't support backdrop filters, the theme gracefully degrades to using just the translucent background.
