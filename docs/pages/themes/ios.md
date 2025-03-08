# PHPFlasher iOS Theme

## Overview

The iOS theme provides notifications styled after Apple's iOS notification system, creating a familiar experience for users of iPhones and iPads. It features Apple's distinctive frosted glass effect, app icon style, and subtle animations that mimic native iOS notifications.

![iOS Theme Preview](./images/ios-theme.png)

## Features

- **Frosted Glass Effect**: Semi-transparent background with backdrop blur
- **App Icon**: Type-specific colored app icon with white symbol
- **iOS Typography**: Apple's San Francisco font (with system fallbacks)
- **Current Time**: Real-time timestamp in iOS format
- **Smooth Animations**: iOS-like entrance and content expansion animations
- **iOS-Style Close Button**: Small circular button in the top right
- **Dark Mode Support**: Proper implementation of iOS dark appearance
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { iosTheme } from '@flasher/flasher/themes';
flasher.addTheme('ios', iosTheme);

// Use the theme
flasher.use('theme.ios').success('Your photo was uploaded successfully');
flasher.use('theme.ios').error('Unable to connect to server');
flasher.use('theme.ios').warning('Low storage space on your device');
flasher.use('theme.ios').info('New software update available');

// With a custom app name (title)
flasher.use('theme.ios').success('Message sent', 'Messages');

// Set as default theme
flasher.defaultPlugin = 'theme.ios';
```

## Customization

The iOS theme uses CSS variables that can be customized to match your brand while maintaining the iOS look:

```css
:root {
    /* Base appearance */
    --ios-bg-light: rgba(255, 255, 255, 0.85);  /* Light mode background */
    --ios-bg-dark: rgba(30, 30, 30, 0.85);      /* Dark mode background */
    --ios-text-light: #000000;                  /* Light mode text */
    --ios-text-secondary-light: #6e6e6e;        /* Light mode secondary text */
    --ios-border-radius: 13px;                  /* Corner radius */
    --ios-blur: 30px;                           /* Backdrop blur amount */
    
    /* Type colors - based on iOS system colors */
    --ios-success: #34c759;                     /* iOS green */
    --ios-info: #007aff;                        /* iOS blue */
    --ios-warning: #ff9500;                     /* iOS orange */
    --ios-error: #ff3b30;                       /* iOS red */
}
```

## Structure

The iOS theme generates notifications with the following HTML structure:

```html
<div class="fl-ios fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-ios-notification">
        <div class="fl-header">
            <div class="fl-app-icon">
                <!-- SVG icon -->
            </div>
            <div class="fl-app-info">
                <div class="fl-app-name">App Name/Title</div>
                <div class="fl-time">Current time</div>
            </div>
        </div>
        <div class="fl-content">
            <div class="fl-message">Message text</div>
        </div>
        <button class="fl-close" aria-label="Close [type] message">
            <span aria-hidden="true">×</span>
        </button>
    </div>
</div>
```

## Animation Details

The iOS theme features two carefully crafted animations that work together to create a smooth, iOS-like appearance:

### Entrance Animation

The main notification slides in from above with a subtle scaling effect:

```css
@keyframes iosSlideIn {
    0% {
        opacity: 0;
        transform: translateY(-15px) scale(0.96);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
```

This animation uses a custom easing curve (cubic-bezier(0.23, 1, 0.32, 1)) which mimics the iOS animation style with a quick start and gentle end.

### Content Expansion Animation

After the notification appears, the content area expands with a slight delay:

```css
@keyframes iosExpand {
    0% {
        max-height: 0;
        opacity: 0;
    }
    100% {
        max-height: 100px;
        opacity: 1;
    }
}
```

This creates a subtle two-step effect where the header appears first, followed by the message content—similar to how iOS reveals notification content.

## iOS-Specific Design Elements

### Frosted Glass Effect

The iOS theme uses `backdrop-filter: blur()` to create Apple's signature frosted glass effect. This creates a semi-transparent background that blurs content behind the notification.

### App Icon

The app icon follows iOS design principles:
- Square with slightly rounded corners (5px radius)
- Colored background based on notification type
- White icon centered within the square

### Typography

The theme uses Apple's system font stack:
- San Francisco on Apple devices
- Appropriate fallbacks for other platforms
- Font weights and sizes that match iOS notifications

### Close Button

The close button mimics iOS UI elements:
- Small circular button (18px diameter)
- Semi-transparent background
- Simple "×" symbol
- Subtle hover effect

## Dark Mode

The iOS theme implements Apple's dark mode approach:
- Dark semi-transparent background
- Light text
- Adjusted shadows for better visibility
- Lighter close button background

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables animations
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: Maintains proper contrast ratios in both light and dark modes
- **Mobile Optimization**: Responsive design that adjusts for small screens

## Browser Support

The iOS theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

For browsers that don't support backdrop-filter, the theme gracefully degrades to using just the semi-transparent background without blur.

## Implementation Notes

- The theme automatically displays the current time in a format similar to iOS notifications
- The title parameter is used as the "app name" in the notification
- If no title is provided, it defaults to "PHPFlasher"
- The theme does not include a progress bar, matching iOS's notification style
