# PHPFlasher Ruby Theme

## Overview

The Ruby theme provides vibrant notifications with rich gradient backgrounds and a distinctive gemstone-like appearance. It features an elegant shine animation that mimics light reflecting off a precious stone, along with circular icon containers and smooth animations to create a premium, eye-catching visual experience.

![Ruby Theme Preview](./images/ruby-theme.png)

## Features

- **Gradient Backgrounds**: Rich, vibrant gradients for each notification type
- **Gemstone Shine Effect**: Animated light reflection that moves across notifications
- **Circular Icon Container**: Translucent white circle housing the notification icon
- **Scale Animation**: Smooth entrance with a subtle scale effect
- **Enhanced Close Button**: Interactive button with scale and opacity effects
- **Thick Progress Bar**: More prominent progress indicator than other themes
- **High Contrast Text**: White text for excellent readability on colored backgrounds
- **RTL Support**: Full right-to-left language support
- **Reduced Motion Support**: Respectful fallbacks for users who prefer reduced motion

## Usage

```typescript
// Import the theme (if not auto-registered)
import { rubyTheme } from '@flasher/flasher/themes';
flasher.addTheme('ruby', rubyTheme);

// Use the theme
flasher.use('theme.ruby').success('Your changes have been saved');
flasher.use('theme.ruby').error('There was a problem saving your changes');
flasher.use('theme.ruby').warning('This action cannot be undone');
flasher.use('theme.ruby').info('New features are available');

// Set as default theme
flasher.defaultPlugin = 'theme.ruby';
```

## Customization

The Ruby theme uses CSS variables that can be customized:

```css
:root {
    /* Base appearance */
    --ruby-text: #ffffff;                        /* Text color */
    --ruby-border-radius: 1.125rem;              /* Corner roundness */
    --ruby-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.2); /* Shadow depth */
    
    /* Type-specific gradients */
    --ruby-success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%); /* Success */
    --ruby-info-gradient: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);    /* Info */
    --ruby-warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); /* Warning */
    --ruby-error-gradient: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);   /* Error */
}
```

## Structure

The Ruby theme generates notifications with the following HTML structure:

```html
<div class="fl-ruby fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-shine"></div>
    <div class="fl-content">
        <div class="fl-icon-circle">
            <div class="fl-icon"></div>
        </div>
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

## Animation Details

The Ruby theme features two distinctive animations:

### Shine Animation

```css
@keyframes rubyShine {
    0% {
        left: -100%;
        opacity: 0.6;
    }
    60% {
        left: 100%;
        opacity: 0.6;
    }
    100% {
        left: 100%;
        opacity: 0;
    }
}
```

This animation creates a moving highlight that travels across the notification from left to right, mimicking light reflecting off a gemstone surface. The effect:
- Is angled with a skew transform
- Uses a semi-transparent white gradient
- Repeats every 6 seconds after an initial 1-second delay
- Fades out at the end of each cycle

### Entrance Animation

```css
@keyframes rubyIn {
    0% {
        opacity: 0;
        transform: scale(0.96);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
```

This animation creates a smooth appearance where notifications:
- Fade in from invisible to fully visible
- Scale up slightly from 96% to 100% of their final size

The animation uses a custom easing curve (`cubic-bezier(0.21, 1.02, 0.73, 1)`) for a natural, premium feel.

## Gradient Design

The theme uses rich, vibrant gradients that flow from a deeper shade to a brighter one:

- **Success**: Green gradient from #059669 to #10b981
- **Info**: Blue gradient from #2563eb to #3b82f6
- **Warning**: Amber gradient from #d97706 to #f59e0b
- **Error**: Red gradient from #b91c1c to #ef4444

All gradients are angled at 135 degrees, creating a consistent diagonal flow across all notification types.

## Icon Container Design

The circular icon container uses:
- Semi-transparent white background (25% opacity)
- Perfect circular shape (border-radius: 50%)
- 36px diameter (2.25rem)
- Centered icon with white color

This creates a subtle but distinctive visual element that helps identify the notification type.

## Progress Bar

The Ruby theme features a more prominent progress bar:
- 5px height (taller than most themes)
- Semi-transparent black background (10% opacity)
- Semi-transparent white progress indicator (40% opacity)
- Positioned at the bottom edge of the notification

## Close Button Design

The close button has several interactive features:
- Semi-transparent white background (20% opacity)
- Perfect circular shape
- Scale effect on hover (grows to 105% size)
- Opacity change from 80% to 100% on hover
- Background lightens to 30% opacity on hover

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query by disabling animations and shine effect
- **Color Contrast**: White text (#ffffff) on colored backgrounds meets WCAG 2.1 AA contrast requirements
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **RTL Support**: Complete right-to-left language support with appropriate directional adjustments

## Design Philosophy

The Ruby theme embodies a premium, attention-grabbing design philosophy:
1. **Vibrance**: Rich, saturated colors that stand out
2. **Movement**: Dynamic shine animation that draws the eye
3. **Depth**: Shadows and translucent elements create a layered appearance
4. **Polish**: Refined animations and hover states reflect a premium quality
5. **Legibility**: Despite the colorful backgrounds, text remains highly readable

## Browser Support

The Ruby theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

The gradient backgrounds and animations are well-supported across modern browsers, requiring no special fallbacks.
