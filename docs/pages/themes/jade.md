# PHPFlasher Jade Theme

## Overview

The Jade theme provides a calm, minimalist notification style with soft colors and subtle animations. It features a clean design that emphasizes message content through generous padding, rounded corners, and type-specific color schemes. The theme takes its name from the natural, soothing quality of its appearance.

![Jade Theme Preview](./images/jade-theme.png)

## Features

- **Minimalist Design**: Clean layout without icons for a streamlined appearance
- **Soft Color Palette**: Gentle, pastel backgrounds with contrasting text colors
- **Rounded Corners**: Large border radius (1rem) for a friendly, approachable feel
- **Subtle Animation**: Combined scaling and movement for an elegant entrance
- **Type-Specific Styling**: Each notification type has its own color scheme
- **Refined Interactions**: Thoughtful hover effects and transitions
- **Progress Indicator**: Subtle progress bar showing time remaining
- **Dark Mode Support**: Complete dark mode implementation with adjusted colors
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { jadeTheme } from '@flasher/flasher/themes';
flasher.addTheme('jade', jadeTheme);

// Use the theme
flasher.use('theme.jade').success('Your changes have been saved');
flasher.use('theme.jade').error('An error occurred while saving changes');
flasher.use('theme.jade').warning('Your session will expire in 5 minutes');
flasher.use('theme.jade').info('New features have been added');

// Set as default theme
flasher.defaultPlugin = 'theme.jade';
```

## Customization

The Jade theme uses CSS variables that can be customized to match your brand while maintaining its calm aesthetic:

```css
:root {
    /* Base appearance */
    --jade-text-light: #5f6c7b;                /* Text color in light mode */
    --jade-text-dark: #e2e8f0;                 /* Text color in dark mode */
    --jade-border-radius: 1rem;                /* Corner roundness */
    
    /* Type-specific colors - Light mode */
    --jade-success-bg: #f0fdf4;                /* Success background */
    --jade-success-color: #16a34a;             /* Success text/accent */
    --jade-info-bg: #eff6ff;                   /* Info background */
    --jade-info-color: #3b82f6;                /* Info text/accent */
    --jade-warning-bg: #fffbeb;                /* Warning background */
    --jade-warning-color: #f59e0b;             /* Warning text/accent */
    --jade-error-bg: #fef2f2;                  /* Error background */
    --jade-error-color: #dc2626;               /* Error text/accent */
    
    /* Dark mode backgrounds */
    --jade-success-bg-dark: rgba(22, 163, 74, 0.15);  /* Dark mode success */
    --jade-info-bg-dark: rgba(59, 130, 246, 0.15);    /* Dark mode info */
    --jade-warning-bg-dark: rgba(245, 158, 11, 0.15); /* Dark mode warning */
    --jade-error-bg-dark: rgba(220, 38, 38, 0.15);    /* Dark mode error */
}
```

## Structure

The Jade theme generates notifications with the following HTML structure:

```html
<div class="fl-jade fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-message">Message text</div>
        <button class="fl-close" aria-label="Close [type] message">×</button>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

## Animation

The Jade theme features a refined entrance animation that combines two effects:

```css
@keyframes jadeIn {
    0% {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
```

This animation creates a subtle effect where notifications:
1. Fade in from invisible to fully visible
2. Move upward slightly from their final position
3. Scale from 95% to 100% of their final size

The combination of these effects creates a more organic, refined entrance than simple fades or slides. The animation uses a carefully tuned easing curve (`cubic-bezier(0.4, 0, 0.2, 1)`) for a natural feel.

## Design Philosophy

The Jade theme embodies several design principles:

1. **Simplicity**: Only essential elements are included, with no icons or extraneous components
2. **Softness**: Rounded corners, pastel colors, and subtle transitions create a gentle feel
3. **Clarity**: Clear color coding with strong contrast between background and text
4. **Refinement**: Thoughtful attention to details like animation timing and hover states
5. **Consistency**: Each notification type follows the same pattern with its own color scheme

## Color System

The Jade theme uses a dual-color system for each notification type:

- **Background**: Very light, pastel version of the type color (e.g., very light green for success)
- **Text/Accents**: More saturated version of the same color (e.g., medium green for success text)

This approach maintains excellent readability while providing clear visual differentiation between notification types.

## Dark Mode

In dark mode, the theme switches to semi-transparent colored backgrounds that create a subtle glow effect:

- Base text becomes lighter (#e2e8f0)
- Backgrounds use semi-transparent colored overlays (15% opacity)
- Borders become slightly more visible (20% opacity instead of 10%)
- Hover states use white instead of black (10% white opacity)

This creates a cohesive dark appearance that maintains the theme's calm aesthetic.

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Button Labeling**: Close button has descriptive aria-label for screen readers

## Browser Support

The Jade theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
