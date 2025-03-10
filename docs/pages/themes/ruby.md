---
permalink: /theme/ruby/
title: Ruby Theme
description: Add vibrant notifications with rich gradient backgrounds to your application using the Ruby theme for PHPFlasher. Featuring an elegant shine animation, circular icons, and gemstone-like appearance.
handler: theme.ruby
data-controller: theme-ruby
---

## <i class="fa-solid fa-gem text-red-500"></i> Ruby Theme

The Ruby theme provides vibrant notifications with rich gradient backgrounds and a distinctive gemstone-like appearance. It features an elegant shine animation that mimics light reflecting off a precious stone, along with circular icon containers and smooth animations to create a premium, eye-catching visual experience.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Ruby theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.ruby',  // Make Ruby the default theme
    
    'themes' => [
        'ruby' => [
            'scripts' => [
                '/vendor/flasher/themes/ruby.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/ruby.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.ruby  # Make Ruby the default theme
    
    themes:
        ruby:
            scripts:
                - '/vendor/flasher/themes/ruby.min.js'
            styles:
                - '/vendor/flasher/themes/ruby.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { rubyTheme } from '@flasher/flasher/themes';
flasher.addTheme('ruby', rubyTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.ruby';

// Or use it for specific notifications
flasher.success('Your changes have been saved');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Ruby styling:

{% assign successMessage = 'Your changes have been saved successfully.' %}
{% assign errorMessage = 'There was a problem saving your changes.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New features are available.' %}

<script type="text/javascript">
    messages['#/ ruby types'] = [
        {
            handler: 'theme.ruby',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'ruby' },
        },
        {
            handler: 'theme.ruby',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'ruby' },
        },
        {
            handler: 'theme.ruby',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'ruby' },
        },
        {
            handler: 'theme.ruby',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'ruby' },
        }
    ];
</script>

### PHP

```php
#/ ruby types

// With Ruby set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Ruby set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Ruby Theme for Specific Notifications

If Ruby isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.ruby')
    ->success('This notification uses Ruby theme.');
```

#### JavaScript

```javascript
flasher.use('theme.ruby').success('This notification uses Ruby theme.');
```

### Custom Colors and Appearance

The Ruby theme uses CSS variables that can be customized to match your brand:

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

## <i class="fa-solid fa-code"></i> HTML Structure

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

This structure includes the shine element that creates the gemstone-like reflection animation and the circular icon container that's distinctive to this theme.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Gradient Design

The theme uses rich, vibrant gradients that flow from a deeper shade to a brighter one:

- **Success**: Green gradient from #059669 to #10b981
- **Info**: Blue gradient from #2563eb to #3b82f6
- **Warning**: Amber gradient from #d97706 to #f59e0b
- **Error**: Red gradient from #b91c1c to #ef4444

All gradients are angled at 135 degrees, creating a consistent diagonal flow across all notification types.

### Shine Animation

The Ruby theme features a distinctive shine animation that mimics light reflecting off a gemstone surface:

- A moving highlight travels across the notification from left to right
- The effect is angled with a skew transform
- Uses a semi-transparent white gradient
- Repeats every 6 seconds after an initial 1-second delay
- Fades out at the end of each cycle

This animation adds a premium, dynamic quality to the notifications that draws the user's attention.

### Circular Icon Container

The circular icon container uses:
- Semi-transparent white background (25% opacity)
- Perfect circular shape (border-radius: 50%)
- 36px diameter (2.25rem)
- Centered icon with white color

This creates a subtle but distinctive visual element that helps identify the notification type.

### Animation Effects

In addition to the shine animation, the Ruby theme includes:

- **Entrance Animation**: A smooth scale-up from 96% to 100% combined with a fade-in
- **Close Button Interactions**: Scale and opacity changes on hover
- **Progress Bar Animation**: A fluid countdown indicator

### Design Philosophy

The Ruby theme embodies a premium, attention-grabbing design philosophy:
1. **Vibrance**: Rich, saturated colors that stand out
2. **Movement**: Dynamic shine animation that draws the eye
3. **Depth**: Shadows and translucent elements create a layered appearance
4. **Polish**: Refined animations and hover states reflect a premium quality
5. **Legibility**: Despite the colorful backgrounds, text remains highly readable

### Accessibility Features

The Ruby theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query by disabling animations and shine effect
- **Color Contrast**: White text (#ffffff) on colored backgrounds meets WCAG 2.1 AA contrast requirements
- **Keyboard Access**: Close button is fully keyboard accessible with visual feedback
- **RTL Support**: Complete right-to-left language support with appropriate directional adjustments

## <i class="fa-solid fa-browser"></i> Browser Support

The Ruby theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

The gradient backgrounds and animations are well-supported across modern browsers, requiring no special fallbacks.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Ruby theme uses modern web technologies:

- **CSS Variables**: For theme customization
- **CSS Gradients**: For rich, vibrant backgrounds
- **CSS Animations**: For shine effect and entrance animations
- **CSS Transitions**: For smooth hover interactions
- **Box Shadows**: For depth and premium feel
- **SVG Icons**: For crisp, scalable notification type indicators
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.
