# PHPFlasher Sapphire Theme

## Overview

The Sapphire theme provides modern, glassmorphic notifications with a blurred backdrop effect. It features a clean, minimal design that emphasizes simplicity and contemporary aesthetics, with semi-transparent colored backgrounds and subtle animations that create a sophisticated, unobtrusive appearance.

![Sapphire Theme Preview](./images/sapphire-theme.png)

## Features

- **Glassmorphic Design**: Semi-transparent backgrounds with backdrop blur effect
- **Minimal Interface**: Clean design without icons or close buttons
- **Bounce Animation**: Subtle entrance animation with a slight bounce effect
- **Colored Backgrounds**: Type-specific colors with high transparency
- **Progress Indicator**: Clean progress bar showing time remaining
- **Modern Typography**: Uses Roboto font for a contemporary look
- **Type-Based Colors**: Each notification type has its own colored background
- **RTL Support**: Full right-to-left language support
- **Reduced Motion Support**: Respects user preferences for reduced motion

## Usage

```typescript
// Import the theme (if not auto-registered)
import { sapphireTheme } from '@flasher/flasher/themes';
flasher.addTheme('sapphire', sapphireTheme);

// Use the theme
flasher.use('theme.sapphire').success('Your changes have been saved');
flasher.use('theme.sapphire').error('There was a problem saving your changes');
flasher.use('theme.sapphire').warning('This action cannot be undone');
flasher.use('theme.sapphire').info('New features are available');

// Set as default theme
flasher.defaultPlugin = 'theme.sapphire';
```

## Customization

The Sapphire theme uses CSS variables that can be customized:

```css
:root {
    /* Base appearance */
    --sapphire-bg-base: rgba(30, 30, 30, 0.9);    /* Base background color */
    --sapphire-text: #f0f0f0;                     /* Text color */
    --sapphire-shadow: rgba(0, 0, 0, 0.15);       /* Shadow color */
    
    /* Progress bar colors */
    --sapphire-progress-bg: rgba(255, 255, 255, 0.2);  /* Progress background */
    --sapphire-progress-fill: rgba(255, 255, 255, 0.9); /* Progress fill */
    
    /* Notification type colors */
    --sapphire-success: rgba(16, 185, 129, 0.95); /* Success color */
    --sapphire-error: rgba(239, 68, 68, 0.95);    /* Error color */
    --sapphire-warning: rgba(245, 158, 11, 0.95); /* Warning color */
    --sapphire-info: rgba(59, 130, 246, 0.95);    /* Info color */
}
```

## Structure

The Sapphire theme generates notifications with the following HTML structure:

```html
<div class="fl-sapphire fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <span class="fl-message">Message text</span>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

Note that unlike most themes, Sapphire intentionally omits a close button and icons for a more streamlined appearance.

## Animation Details

The Sapphire theme features a distinctive bounce animation for a more dynamic entrance:

```css
@keyframes sapphireIn {
    0% {
        opacity: 0;
        transform: translateY(10px);
    }
    60% {
        transform: translateY(-3px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
```

This animation creates a refined entrance where notifications:
1. Fade in from invisible to fully visible
2. Move upward from below their final position
3. Slightly overshoot their target position before settling (bounce effect)

The animation uses a carefully tuned easing curve (`cubic-bezier(0.25, 0.46, 0.45, 0.94)`) that enhances the natural feel of the motion.

## Glassmorphic Design

The Sapphire theme implements the popular glassmorphism design trend:

```css
backdrop-filter: blur(12px);
-webkit-backdrop-filter: blur(12px);
```

This creates a frosted glass effect where:
- The notification background is semi-transparent
- Content behind the notification appears blurred
- The effect creates depth and visual interest
- The notification feels like it's floating above the content

## Minimalist Approach

Unlike many notification themes, Sapphire takes a distinctly minimalist approach:

- No close button (notifications auto-dismiss)
- No icons or visual indicators beyond color
- Clean typography with minimal styling
- Focus purely on the message content
- Subtle progress indicator

This approach reduces visual noise and creates a more elegant, unobtrusive notification experience.

## Color System

The Sapphire theme uses a sophisticated color system:

- High transparency backgrounds (95% opacity)
- Type-specific colors that maintain a consistent visual language
- Light text (#f0f0f0) for excellent contrast on all background colors
- Semi-transparent progress indicator that works across all notification types

## Typography

The theme prioritizes clean, modern typography:

- Prefers the Roboto font for a contemporary look
- Comfortable line height (1.4) for easy reading
- Slightly smaller than standard text size (0.925em)
- Consistent text color across all notification types

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables animations
- **Color Contrast**: Ensures good contrast between text and all background colors
- **RTL Support**: Complete right-to-left language support

## Browser Support

The Sapphire theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

For browsers that don't support backdrop-filter (like older Firefox versions), the theme gracefully degrades to using just the semi-transparent background without the blur effect.

## Font Considerations

For the best experience with the Sapphire theme, it's recommended to include the Roboto font in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
```

If Roboto is not available, the theme falls back to the system font stack while maintaining its clean aesthetic.
