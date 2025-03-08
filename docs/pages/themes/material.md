# PHPFlasher Material Theme

## Overview

The Material theme provides a minimalist implementation of Google's Material Design system for notifications. It features clean cards with proper elevation, Material Design typography, and interactive elements that follow Material guidelines, all without unnecessary visual elements to maintain focus on the message content.

![Material Theme Preview](./images/material-theme.png)

## Features

- **Material Design Card**: Clean, elevated card with proper shadow depth
- **Minimalist Approach**: No icons or extraneous elements for a focused experience
- **Material Typography**: Roboto font with proper text hierarchy and opacity
- **Action Button**: DISMISS button with uppercase text following Material conventions
- **Ripple Effect**: Interactive feedback with ripple animation on button press
- **Slide-Up Animation**: Smooth entrance animation with Material motion easing
- **Linear Progress**: Material Design progress indicator at the bottom
- **Dark Mode Support**: Proper implementation of Material dark theme
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { materialTheme } from '@flasher/flasher/themes';
flasher.addTheme('material', materialTheme);

// Use the theme
flasher.use('theme.material').success('Operation completed successfully');
flasher.use('theme.material').error('An error occurred during the operation');
flasher.use('theme.material').warning('This action cannot be undone');
flasher.use('theme.material').info('New updates are available');

// Set as default theme
flasher.defaultPlugin = 'theme.material';
```

## Customization

The Material theme uses CSS variables that can be customized to match your brand while maintaining the Material Design feel:

```css
:root {
    /* Base appearance */
    --md-bg-light: #ffffff;              /* Light mode background */
    --md-bg-dark: #2d2d2d;               /* Dark mode background */
    --md-text-light: rgba(0, 0, 0, 0.87); /* Primary text in light mode */
    --md-text-secondary-light: rgba(0, 0, 0, 0.6); /* Secondary text in light mode */
    --md-elevation: 0 3px 5px -1px rgba(0,0,0,0.2), 0 6px 10px 0 rgba(0,0,0,0.14), 0 1px 18px 0 rgba(0,0,0,0.12); /* Card shadow */
    --md-border-radius: 4px;             /* Card corner radius */
    
    /* Type colors - based on Material palette */
    --md-success: #43a047;               /* Green 600 */
    --md-info: #1e88e5;                  /* Blue 600 */
    --md-warning: #fb8c00;               /* Orange 600 */
    --md-error: #e53935;                 /* Red 600 */
    
    /* Animation timing */
    --md-animation-duration: 0.3s;       /* Entrance animation duration */
    --md-ripple-duration: 0.6s;          /* Button ripple effect duration */
}
```

## Structure

The Material theme generates notifications with the following HTML structure:

```html
<div class="fl-material fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-md-card">
        <div class="fl-content">
            <div class="fl-text-content">
                <div class="fl-message">Message text</div>
            </div>
        </div>
        <div class="fl-actions">
            <button class="fl-action-button fl-close" aria-label="Close [type] message">
                DISMISS
            </button>
        </div>
    </div>
    <div class="fl-progress-bar">
        <div class="fl-progress"></div>
    </div>
</div>
```

## Material Design Elements

### Elevation

The theme uses proper Material Design elevation with three shadow components:

1. **Umbra**: The darkest, sharpest shadow representing the main shadow
2. **Penumbra**: The mid-tone, slightly softer shadow
3. **Ambient**: The lightest, most diffuse shadow

This creates the characteristic Material Design "floating" effect for cards.

### Typography

Following Material Design typography guidelines:

- **Message**: 14px (0.875rem), regular weight (400), 60% opacity for secondary text
- **Button**: 13px (0.8125rem), medium weight (500), uppercase with letterSpacing

### Ripple Effect

The theme includes Material Design's signature "ink ripple" effect:

1. A small circle appears at the point of interaction
2. The circle rapidly expands outward
3. The effect fades out as it reaches full size

This provides visual feedback that enhances the tactile feeling of the interface.

## Animation Details

### Entrance Animation

The Material theme uses Material Design's standard motion curve (cubic-bezier(0.4, 0, 0.2, 1)) for its slide-up animation. This creates a natural-feeling motion that follows the principles of Material motion:

- Quick acceleration from start
- Smooth deceleration to end
- Total duration of 300ms

### Interaction Animations

The theme includes several interaction animations:

1. **Button Hover**: Background color transition (200ms)
2. **Button Press**: Ripple effect (600ms)
3. **Progress Bar**: Linear progress animation

## Differences from Google Theme

While both the Material theme and Google theme follow Material Design guidelines, they differ in these key ways:

1. **Minimalist Approach**: The Material theme omits icons entirely for a more streamlined appearance
2. **Focus on Content**: With fewer visual elements, more focus is placed on the message text
3. **Simplified Structure**: The HTML structure is more straightforward without icon containers

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables animations
- **Keyboard Access**: Action button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Text Alternatives**: Descriptive aria-labels for interactive elements

## Dark Mode

The Material theme implements Material Design's dark theme guidelines:

- Dark surfaces (#2d2d2d)
- Light text (87% white for primary, 60% white for secondary)
- Adjusted shadows for better visibility on dark backgrounds
- Higher contrast for hover states (8% opacity instead of 4%)

## Font Considerations

For the best experience, it's recommended to include the Roboto font in your project:

```html
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">
```

If Roboto is not available, the theme falls back to system fonts while maintaining the Material Design aesthetic as much as possible.

## Browser Support

The Material theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

The ripple effect and other animations may have slightly different appearances across browsers, but the core functionality works everywhere.
