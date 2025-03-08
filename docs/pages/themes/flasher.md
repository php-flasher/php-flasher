# PHPFlasher Default Theme

## Overview

The Flasher theme is the default notification theme for PHPFlasher. It provides a classic, clean design with a distinctive colored left border that visually indicates the notification type. This theme balances visual clarity with simplicity, making it suitable for a wide range of applications.

![Flasher Theme Preview](./images/flasher-theme.png)

## Features

- **Colored Left Border**: Prominent left border that clearly indicates notification type
- **Type-Specific Icons**: Each notification type has its own distinctive icon
- **Title & Message**: Supports both a title and message text for clear communication
- **Hover Animation**: Subtle lift effect when hovering over notifications
- **Progress Bar**: Shows the time remaining before auto-dismiss
- **Slide-in Animation**: Smooth entrance animation from the left
- **Dark Mode Support**: Complete dark mode implementation with optimized colors
- **RTL Support**: Full right-to-left language support

## Usage

The Flasher theme is available by default without requiring explicit registration:

```typescript
// Use directly without specifying a theme
flasher.success('Operation completed successfully');
flasher.error('An error occurred during the operation');
flasher.warning('This action cannot be undone');
flasher.info('New updates are available');

// Or explicitly use the theme
flasher.use('theme.flasher').success('Operation completed successfully');

// With a title
flasher.success('Operation completed successfully', 'Success');
```

## Customization

The Flasher theme uses CSS variables that can be customized:

```css
:root {
    /* Base colors */
    --fl-bg-light: #ffffff;            /* Light mode background */
    --fl-bg-dark: rgb(15, 23, 42);     /* Dark mode background */
    --fl-text-light: rgb(75, 85, 99);  /* Light mode text */
    --fl-text-dark: #ffffff;           /* Dark mode text */
    
    /* Type colors */
    --fl-success: #10b981;             /* Success color */
    --fl-info: #3b82f6;                /* Info color */
    --fl-warning: #f59e0b;             /* Warning color */
    --fl-error: #ef4444;               /* Error color */
    
    /* Legacy support */
    --background-color: var(--fl-bg-light);
    --text-color: var(--fl-text-light);
    --dark-background-color: var(--fl-bg-dark);
    --dark-text-color: var(--fl-text-dark);
    --success-color: var(--fl-success);
    --info-color: var(--fl-info);
    --warning-color: var(--fl-warning);
    --error-color: var(--fl-error);
}
```

## Structure

The Flasher theme generates notifications with the following HTML structure:

```html
<div class="fl-flasher fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-content">
        <div class="fl-icon"></div>
        <div>
            <strong class="fl-title">Title text</strong>
            <span class="fl-message">Message text</span>
        </div>
        <button class="fl-close" aria-label="Close [type] message">&times;</button>
    </div>
    <span class="fl-progress-bar">
        <span class="fl-progress"></span>
    </span>
</div>
```

## Animation

The Flasher theme features two animations:

1. **Entrance Animation**: A slide-in from the left with a fade-in effect:
   ```css
   @keyframes flasherIn {
       from {
           opacity: 0;
           transform: translateX(-10px);
       }
       to {
           opacity: 1;
           transform: translateX(0);
       }
   }
   ```

2. **Hover Animation**: A subtle lift effect when hovering over notifications:
   ```css
   &:hover {
       transform: translateY(-2px);
   }
   ```

Both animations are disabled for users who prefer reduced motion.

## Design Philosophy

As the default theme for PHPFlasher, the Flasher theme is designed with these principles:

1. **Clarity**: The colored left border makes it immediately clear what type of notification is being shown
2. **Versatility**: The clean design fits well in a wide range of applications and design systems
3. **Accessibility**: High contrast, clear typography, and semantic HTML ensure notifications are accessible
4. **Familiarity**: The design follows common notification patterns that users will find intuitive

## Visual Characteristics

- **Border**: Thick, colored left border (0.8em) that visually identifies the notification type
- **Typography**: Clear hierarchy with distinct title and message styles
- **Shadow**: Subtle shadow that gives depth without being too prominent
- **Icons**: Type-specific icons that help with quick visual identification
- **Progress Bar**: Thin progress indicator at the bottom that shows remaining time

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Contrast**: All text meets WCAG 2.1 AA color contrast standards
- **RTL Support**: Full right-to-left language support with appropriately mirrored layout

## Browser Support

The Flasher theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Implementation Details

The Flasher theme is built using:

- **SCSS Mixins**: Uses shared mixins for common functionality
- **CSS Variables**: For theme customization and consistency
- **Flexbox**: For layout structure
- **CSS Animation**: For entrance and hover effects
- **Media Queries**: For responsive design, dark mode, and reduced motion
- **CSS Transitions**: For smooth hover interactions
