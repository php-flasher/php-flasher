# PHPFlasher Theme System

## Overview

The PHPFlasher theme system allows for consistent, customizable notification designs across your application. Themes define both the visual appearance (CSS/SCSS) and HTML structure of notifications.

## Core Concepts

### Theme Structure

Each theme consists of:

1. **SCSS file**: Defines the styling for the notification
2. **TypeScript file**: Contains the `render` function that generates HTML
3. **Index file**: Registers the theme with PHPFlasher

### Theme Registration

Themes are registered using the `addTheme` method:

```typescript
flasher.addTheme('themeName', myTheme);
```

### Using Themes

Themes can be used in two ways:

1. **Direct Usage**: Using the theme as a plugin
   ```typescript
   flasher.use('theme.material').success('Operation completed');
   ```

2. **Default Theme**: Setting a theme as the default
   ```typescript
   // Make material theme the default
   const defaultTheme = 'theme.material';
   flasher.defaultPlugin = defaultTheme;
   ```

## Theme Components

### CSS Variables

PHPFlasher uses CSS variables to maintain consistent styling across themes. The main variables are:

```css
:root {
  /* State Colors */
  --fl-success: #10b981;
  --fl-info: #3b82f6;
  --fl-warning: #f59e0b;
  --fl-error: #ef4444;

  /* Base colors */
  --fl-bg-light: #ffffff;
  --fl-bg-dark: rgb(15, 23, 42);
  --fl-text-light: rgb(75, 85, 99);
  --fl-text-dark: #ffffff;

  /* Appearance */
  --fl-font: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  --fl-border-radius: 4px;
  --fl-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
```

### Layout Components

1. **Wrapper** (`fl-wrapper`): Controls positioning and stacking of notifications
2. **Container** (`fl-container`): Base for individual notifications
3. **Progress Bar** (`fl-progress-bar`): Shows time remaining before auto-dismiss
4. **Icons**: Type-specific icons for visual recognition

### SASS Mixins

PHPFlasher provides several mixins to help with theme creation:

1. **variants**: Apply styles to each notification type
   ```scss
   @include variants using($type) {
     background-color: var(--#{$type}-color);
   }
   ```

2. **close-button**: Standard close button styling
   ```scss
   @include close-button;
   ```

3. **rtl-support**: Right-to-left language support
   ```scss
   @include rtl-support;
   ```

4. **progress-bar**: Add a progress bar with type-specific colors
   ```scss
   @include progress-bar(0.125em);
   ```

5. **dark-mode**: Dark mode styling support
   ```scss
   @include dark-mode {
     background-color: var(--fl-bg-dark);
     color: var(--fl-text-dark);
   }
   ```

## Creating Custom Themes

### Basic Theme Structure

```typescript
// my-theme.ts
import './my-theme.scss'
import type { Envelope } from '@flasher/flasher/dist/types'

export const myTheme = {
  render: (envelope: Envelope): string => {
    const { type, title, message } = envelope
    
    return `
      <div class="fl-my-theme fl-${type}">
        <div class="fl-content">
          <strong>${title || type}</strong>
          <p>${message}</p>
          <button class="fl-close">&times;</button>
        </div>
        <div class="fl-progress-bar">
          <div class="fl-progress"></div>
        </div>
      </div>
    `
  },
  
  // Optional: CSS stylesheets to load
  styles: ['path/to/additional-styles.css']
}
```

### SCSS Template

```scss
// my-theme.scss
@use '../mixins' as *;

.fl-my-theme {
  padding: 1rem;
  background-color: white;
  border-radius: 4px;
  box-shadow: var(--fl-shadow);
  
  .fl-content {
    display: flex;
    align-items: center;
  }
  
  // Use built-in mixins for common functionality
  @include close-button;
  @include rtl-support;
  @include progress-bar;
  
  // Type-specific styling
  @include variants using($type) {
    border-left: 3px solid var(--#{$type}-color);
  }
  
  // Dark mode support
  @include dark-mode {
    background-color: var(--fl-bg-dark);
    color: var(--fl-text-dark);
  }
}
```

### Theme Registration

```typescript
// Register your custom theme
import { myTheme } from './my-theme';
flasher.addTheme('custom', myTheme);

// Use your theme
flasher.use('theme.custom').success('This uses my custom theme!');
```

## Included Themes

PHPFlasher comes with several built-in themes:

- **flasher**: Default bordered notification with colored accents (default)
- **material**: Google Material Design inspired notifications
- **bootstrap**: Bootstrap-styled notifications
- **tailwind**: Tailwind CSS styled notifications
- And many more...

## Accessibility Features

PHPFlasher themes include several accessibility features:

1. **ARIA roles**: Appropriate roles (`alert` or `status`) based on type
2. **ARIA live regions**: Assertive for critical messages, polite for others
3. **Reduced motion**: Respects user preferences for reduced animations
4. **RTL support**: Right-to-left language direction support
5. **Keyboard interaction**: Close buttons are keyboard accessible

## Best Practices

1. **Use semantic HTML** in your theme's render function
2. **Leverage CSS variables** for consistent styling
3. **Include proper ARIA attributes** for accessibility
4. **Use the provided mixins** to ensure consistent behavior
5. **Test in both light and dark modes** using the dark mode mixin
