---
permalink: /theme/slack/
title: Slack Theme
description: Add Slack-style notifications to your application with the Slack theme for PHPFlasher. Featuring message bubbles with colored avatars, clean typography, and interactive hover effects.
handler: theme.slack
data-controller: theme-slack
---

## <i class="fa-brands fa-slack"></i> Slack Theme

The Slack theme provides notifications styled after Slack's familiar messaging interface. It features message bubbles with colored avatars, clean typography, and interactive hover effects that closely resemble the appearance and behavior of messages in the popular workplace communication platform.

> <i class="fa-solid fa-circle-info text-blue-400"></i> **Note:**
> New to PHPFlasher? Check the [installation guide](/installation/) first.

## <i class="fa-solid fa-wand-magic-sparkles"></i> Setup

The easiest way to use the Slack theme is to set it as your **default theme**:

### <i class="fa-brands fa-laravel fa-lg text-red-900 mr-1"></i> Laravel

```php
<?php // config/flasher.php

return [
    'default' => 'theme.slack',  // Make Slack the default theme
    
    'themes' => [
        'slack' => [
            'scripts' => [
                '/vendor/flasher/themes/slack.min.js',
            ],
            'styles' => [
                '/vendor/flasher/themes/slack.min.css',
            ],
        ],
    ],
];
```

### <i class="fa-brands fa-symfony fa-lg text-black mr-1"></i> Symfony

```yaml
# config/packages/flasher.yaml

flasher:
    default: theme.slack  # Make Slack the default theme
    
    themes:
        slack:
            scripts:
                - '/vendor/flasher/themes/slack.min.js'
            styles:
                - '/vendor/flasher/themes/slack.min.css'
```

### <i class="fa-brands fa-js fa-lg text-yellow-400 mr-1"></i> JavaScript/TypeScript

```typescript
// Import the theme (if not auto-registered)
import { slackTheme } from '@flasher/flasher/themes';
flasher.addTheme('slack', slackTheme);

// Set as default theme
flasher.defaultPlugin = 'theme.slack';

// Or use it for specific notifications
flasher.success('Your file was uploaded successfully');
```

## <i class="fa-solid fa-palette"></i> Notification Types

Once configured, use standard PHPFlasher methods to create notifications with Slack styling:

{% assign successMessage = 'Your file was uploaded successfully.' %}
{% assign errorMessage = 'Unable to connect to the server.' %}
{% assign warningMessage = 'Your session will expire soon.' %}
{% assign infoMessage = 'New comments on your post.' %}

<script type="text/javascript">
    messages['#/ slack types'] = [
        {
            handler: 'theme.slack',
            type: 'success',
            message: '{{ successMessage }}',
            options: { theme: 'slack' },
        },
        {
            handler: 'theme.slack',
            type: 'error',
            message: '{{ errorMessage }}',
            options: { theme: 'slack' },
        },
        {
            handler: 'theme.slack',
            type: 'warning',
            message: '{{ warningMessage }}',
            options: { theme: 'slack' },
        },
        {
            handler: 'theme.slack',
            type: 'info',
            message: '{{ infoMessage }}',
            options: { theme: 'slack' },
        }
    ];
</script>

### PHP

```php
#/ slack types

// With Slack set as default theme
flash()->success('{{ successMessage }}');
flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

### JavaScript

```javascript
// With Slack set as default theme
flasher.success('{{ successMessage }}');
flasher.error('{{ errorMessage }}');
flasher.warning('{{ warningMessage }}');
flasher.info('{{ infoMessage }}');
```

## <i class="fa-solid fa-brush"></i> Customization

### Using Slack Theme for Specific Notifications

If Slack isn't your default theme, you can use it for specific notifications:

#### PHP

```php
flash()
    ->use('theme.slack')
    ->success('This notification uses Slack theme.');
```

#### JavaScript

```javascript
flasher.use('theme.slack').success('This notification uses Slack theme.');
```

### Custom Colors and Appearance

The Slack theme uses CSS variables that can be customized to match your brand while maintaining the Slack-like appearance:

```css
:root {
    /* Base appearance */
    --slack-bg-light: #ffffff;                  /* Light mode background */
    --slack-bg-dark: #1a1d21;                   /* Dark mode background */
    --slack-text-light: #1d1c1d;                /* Light mode text */
    --slack-text-dark: #e0e0e0;                 /* Dark mode text */
    --slack-border-light: #e0e0e0;              /* Light mode border */
    --slack-border-dark: #393a3e;               /* Dark mode border */
    --slack-avatar-size: 36px;                  /* Avatar size */
    
    /* Type colors */
    --slack-success: #2bac76;                   /* Success avatar color */
    --slack-info: #1264a3;                      /* Info avatar color */
    --slack-warning: #e8912d;                   /* Warning avatar color */
    --slack-error: #e01e5a;                     /* Error avatar color */
}
```

## <i class="fa-solid fa-code"></i> HTML Structure

The Slack theme generates notifications with the following HTML structure:

```html
<div class="fl-slack fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    <div class="fl-slack-message">
        <div class="fl-avatar">
            <div class="fl-type-icon fl-[type]-icon">[Symbol]</div>
        </div>
        <div class="fl-message-content">
            <div class="fl-message-text">Message text</div>
        </div>
        <div class="fl-actions">
            <button class="fl-close" aria-label="Close [type] message">
                <svg><!-- Close icon --></svg>
            </button>
        </div>
    </div>
</div>
```

This structure mirrors Slack's message layout with an avatar container, message content, and action button.

## <i class="fa-solid fa-lightbulb"></i> Theme Features

### Message Bubble Design

The main container follows Slack's message styling:
- White background (#ffffff) in light mode
- Dark background (#1a1d21) in dark mode
- Subtle border (1px solid #e0e0e0)
- Slight bottom shadow for depth (0 1px 0 rgba(0, 0, 0, 0.1))
- Subtle hover state (#f8f8f8)
- 4px border radius

### Avatar Design

Each notification type has a colored square avatar:
- Success: Green (#2bac76) with ✓ symbol
- Error: Pink/Red (#e01e5a) with ✕ symbol
- Warning: Orange (#e8912d) with ! symbol
- Info: Blue (#1264a3) with i symbol

The avatars are 36px × 36px squares with slightly rounded corners (4px border radius).

### Interactive Elements

The close button appears on hover:
- Initially hidden (opacity: 0, visibility: hidden)
- Fades in when hovering over the message
- Uses Slack's "X" SVG icon
- Changes color on hover (from #616061 to #1d1c1d)
- Has a subtle background on hover (#f8f8f8)

### Animation Effects

The theme uses a simple, quick fade-in animation:
- Duration: 150ms (matches Slack's quick, responsive feel)
- Timing function: ease-out
- Effect: Simple opacity change from 0 to 1

### Typography

The theme uses Slack's typography style:
- Font family: Lato, Slack-Lato, Helvetica Neue, Helvetica, sans-serif
- Font size: 15px for message text
- Line height: 1.46668 (Slack's specific line height)
- Text color: Near black (#1d1c1d) in light mode, off-white (#e0e0e0) in dark mode

### Dark Mode

The dark mode implementation closely matches Slack's dark theme:
- Background: #1a1d21 (Slack's dark mode color)
- Text: #e0e0e0 (light gray)
- Border: #393a3e (dark gray)
- Hover background: #222529 (slightly lighter than the background)

The avatar colors remain consistent between light and dark modes to maintain clear visual indicators.

### Accessibility Features

The Slack theme includes several accessibility features:

- **ARIA Roles**: Uses appropriate `role="alert"` for error/warning and `role="status"` for success/info
- **ARIA Live Regions**: Uses `aria-live="assertive"` for critical messages and `aria-live="polite"` for non-critical messages
- **Reduced Motion**: Respects `prefers-reduced-motion` media query and disables animations
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Indicators**: Each notification type has its own color, but also includes a symbol
- **Text Contrast**: Maintains good contrast ratios in both light and dark modes
- **RTL Support**: Complete right-to-left language support with properly flipped layout

## <i class="fa-solid fa-browser"></i> Browser Support

The Slack theme is compatible with all modern browsers:

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers on iOS and Android

The theme uses standard CSS features that are well-supported across browsers, ensuring a consistent experience for all users.

## <i class="fa-solid fa-gears"></i> Implementation Details

The Slack theme uses modern web technologies:

- **CSS Variables**: For theme customization and dark mode support
- **CSS Flexbox**: For proper message layout and alignment
- **CSS Transitions**: For smooth hover interactions
- **SVG Icons**: For the close button and notification type indicators
- **Media Queries**: For responsive design, dark mode, and reduced motion support

All theme files are optimized for production use, with minified JavaScript and CSS to ensure fast loading times.

For the best experience with the Slack theme, it's recommended to include the Lato font in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
```
