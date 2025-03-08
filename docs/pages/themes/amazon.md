# PHPFlasher Amazon Theme

## Overview

The Amazon theme provides notification styling inspired by Amazon's e-commerce platform. It features clean, minimal design with a focus on readability and accessibility.

![Amazon Theme Preview](./images/amazon-theme.png)

## Features

- **Amazon-Inspired Design**: Clean, minimal styling that matches Amazon's design language
- **Type-Specific Styling**: Each notification type (success, error, warning, info) has unique colors and icons
- **SVG Icons**: Lightweight vector icons that scale perfectly at any size
- **Dark Mode Support**: Full dark mode implementation with type-specific dark colors
- **RTL Support**: Complete right-to-left language support
- **Accessibility**: ARIA roles, reduced motion support, and keyboard accessibility

## Usage

```typescript
// Import the theme (if not auto-registered)
import { amazonTheme } from '@flasher/flasher/themes';
flasher.addTheme('amazon', amazonTheme);

// Use the theme
flasher.use('theme.amazon').success('Your order has been completed successfully');
flasher.use('theme.amazon').error('There was a problem processing your payment');
flasher.use('theme.amazon').warning('Your account will expire in 3 days');
flasher.use('theme.amazon').info('New features have been added to your account');

// Set as default theme
flasher.defaultPlugin = 'theme.amazon';
```

## Customization

The Amazon theme uses CSS variables that can be customized to match your brand:

```css
:root {
    /* Amazon theme colors - Light mode */
    --amazon-success-bg: #f0fff5;       /* Success background */
    --amazon-success-border: #7fda95;   /* Success border */
    --amazon-success-icon: #007600;     /* Success icon color */
    --amazon-info-bg: #f3f9ff;          /* Info background */
    --amazon-info-border: #7fb4da;      /* Info border */
    --amazon-info-icon: #0066c0;        /* Info icon color */
    --amazon-warning-bg: #fffcf3;       /* Warning background */
    --amazon-warning-border: #ffd996;   /* Warning border */
    --amazon-warning-icon: #c45500;     /* Warning icon color */
    --amazon-error-bg: #fff5f5;         /* Error background */
    --amazon-error-border: #ff8f8f;     /* Error border */
    --amazon-error-icon: #c40000;       /* Error icon color */
    
    /* Dark mode colors are also available with -dark suffix */
}
```

## Structure

The Amazon theme generates notifications with the following HTML structure:

```html
<div class="fl-amazon fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-amazon-alert">
        <div class="fl-alert-content">
            <div class="fl-icon-container">
                <!-- SVG icon -->
            </div>
            <div class="fl-text-content">
                <div class="fl-alert-title">Title</div>
                <div class="fl-alert-message">Message</div>
            </div>
        </div>
        <div class="fl-alert-actions">
            <button class="fl-close" aria-label="Close notification">
                <!-- Close icon -->
            </button>
        </div>
    </div>
</div>
```

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages 
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **High Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **Screen Reader Support**: Proper labeling of interactive elements

## Browser Support

The Amazon theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Implementation Details

The Amazon theme uses native CSS features:

- **CSS Variables**: For theme customization
- **Flexbox**: For layout structure
- **SVG Icons**: For resolution-independent icons
- **Media Queries**: For responsive design, dark mode, and reduced motion
