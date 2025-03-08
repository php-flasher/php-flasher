# PHPFlasher Facebook Theme

## Overview

The Facebook theme replicates the familiar notification style from Facebook's interface, providing a user experience that billions of people worldwide will instantly recognize. It features Facebook's signature look and feel, including rounded cards, circular icons, and the platform's distinctive typography and color scheme.

![Facebook Theme Preview](./images/facebook-theme.png)

## Features

- **Facebook-Style Cards**: Rounded notification cards with subtle shadows and hover effects
- **Circular Icons**: Type-specific colored icons in Facebook's style
- **Timestamp Display**: Shows the time when the notification was created
- **Interactive Elements**: Close button with hover effects
- **Facebook Typography**: Uses Facebook's font stack for authentic appearance
- **Dark Mode Support**: Complete dark mode implementation matching Facebook's dark theme
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { facebookTheme } from '@flasher/flasher/themes';
flasher.addTheme('facebook', facebookTheme);

// Use the theme
flasher.use('theme.facebook').success('Your post was published successfully');
flasher.use('theme.facebook').error('There was a problem uploading your photo');
flasher.use('theme.facebook').warning('Your account is approaching storage limits');
flasher.use('theme.facebook').info('3 people reacted to your comment');

// Set as default theme
flasher.defaultPlugin = 'theme.facebook';

// Add a timestamp to your notification
flasher.use('theme.facebook').success('Your post was published', {
  timestamp: '2023-03-08 15:43:27'
});
```

## Customization

The Facebook theme uses CSS variables that can be customized:

```css
:root {
    /* Base colors */
    --fb-bg-light: #ffffff;                  /* Light mode background */
    --fb-bg-dark: #242526;                   /* Dark mode background */
    --fb-text-light: #050505;                /* Light mode primary text */
    --fb-text-secondary-light: #65676b;      /* Light mode secondary text */
    --fb-hover-light: #f0f2f5;               /* Light mode hover state */
    
    /* Type colors */
    --fb-success: #31a24c;                   /* Success color */
    --fb-info: #1876f2;                      /* Info color (Facebook blue) */
    --fb-warning: #f7b928;                   /* Warning color */
    --fb-error: #e41e3f;                     /* Error color */
}
```

## Structure

The Facebook theme generates notifications with the following HTML structure:

```html
<div class="fl-facebook fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-fb-notification">
        <div class="fl-icon-container">
            <div class="fl-fb-icon fl-fb-icon-[type]">
                <!-- SVG icon -->
            </div>
        </div>
        <div class="fl-content">
            <div class="fl-message">Message text</div>
            <div class="fl-meta">
                <span class="fl-time">15:43</span>
            </div>
        </div>
        <div class="fl-actions">
            <button class="fl-button fl-close" aria-label="Close [type] message">
                <div class="fl-button-icon">
                    <!-- Close SVG icon -->
                </div>
            </button>
        </div>
    </div>
</div>
```

## Configuration Options

### Timestamp

You can customize the timestamp displayed in the notification:

```typescript
flasher.use('theme.facebook').success('Your post was published', {
  timestamp: '2023-03-08 15:43:27' // Format: YYYY-MM-DD HH:MM:SS
});
```

If no timestamp is provided, the current time will be used.

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: Maintains Facebook's visual identity while ensuring readability
- **Button Labels**: Close button has descriptive aria-label for screen readers

## Design Notes

### Icons

The theme uses SVG icons similar to those used in Facebook notifications:

- **Success**: Checkmark circle icon
- **Info**: Information circle icon
- **Warning**: Exclamation triangle icon
- **Error**: Alert circle icon

### Dark Mode

The dark mode implementation follows Facebook's dark theme approach:

- Dark background (#242526)
- Light text (#e4e6eb)
- Colored icons with dark backgrounds
- Subtle hover states

### Animation

The entrance animation uses a subtle slide-down with fade effect, providing a familiar experience for Facebook users who are accustomed to seeing notifications appear this way.

## Browser Support

The Facebook theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Implementation Details

- Uses Facebook's font stack for authentic typography
- Implements Facebook's signature color palette
- Recreates Facebook's card design, shadows, and hover effects
- Uses a simplified version of Facebook's notification structure
- Includes timestamps in Facebook's time format
