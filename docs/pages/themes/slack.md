# PHPFlasher Slack Theme

## Overview

The Slack theme provides notifications styled after Slack's familiar messaging interface. It features message bubbles with colored avatars, clean typography, and interactive hover effects that closely resemble the appearance and behavior of messages in the popular workplace communication platform.

![Slack Theme Preview](./images/slack-theme.png)

## Features

- **Message Bubbles**: Clean, bordered containers resembling Slack messages
- **Colored Avatars**: Type-specific colored icon containers (green, blue, orange, red)
- **Slack Typography**: Font styles matching Slack's clean text appearance
- **Hover Interactions**: Background change and button reveal on hover
- **Close Button**: SVG "X" icon that appears when hovering over messages
- **Quick Animation**: Fast fade-in animation for a responsive feel
- **Dark Mode Support**: Dark theme matching Slack's dark mode appearance
- **RTL Support**: Full right-to-left language support

## Usage

```typescript
// Import the theme (if not auto-registered)
import { slackTheme } from '@flasher/flasher/themes';
flasher.addTheme('slack', slackTheme);

// Use the theme
flasher.use('theme.slack').success('Your file was uploaded successfully');
flasher.use('theme.slack').error('Unable to connect to the server');
flasher.use('theme.slack').warning('Your session will expire soon');
flasher.use('theme.slack').info('New comments on your post');

// Set as default theme
flasher.defaultPlugin = 'theme.slack';
```

## Customization

The Slack theme uses CSS variables that can be customized to match your brand while maintaining the Slack-like appearance:

```css
:root {
    /* Base appearance */
    --slack-bg-light: #ffffff;                  /* Light mode background */
    --slack-bg-dark: #1a1d21;                   /* Dark mode background */
    --slack-text-light: #1d1c1d;                /* Light mode text */
    --slack-text-dark: #e0e0e0;                 /* Dark mode text */
    --slack-border-light: #e0e0e0;              /* Light mode border */
    --slack-avatar-size: 36px;                  /* Avatar size */
    
    /* Type colors */
    --slack-success: #2bac76;                   /* Success avatar color */
    --slack-info: #1264a3;                      /* Info avatar color */
    --slack-warning: #e8912d;                   /* Warning avatar color */
    --slack-error: #e01e5a;                     /* Error avatar color */
}
```

## Structure

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

## Design Details

### Message Bubble

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

### Typography

The theme uses Slack's typography style:
- Font family: Lato, Slack-Lato, Helvetica Neue, Helvetica, sans-serif
- Font size: 15px for message text
- Line height: 1.46668 (Slack's specific line height)
- Text color: Near black (#1d1c1d) in light mode, off-white (#e0e0e0) in dark mode

### Animation

The theme uses a simple, quick fade-in animation:
- Duration: 150ms (matches Slack's quick, responsive feel)
- Timing function: ease-out
- Effect: Simple opacity change from 0 to 1

### Interactive Elements

The close button appears on hover:
- Initially hidden (opacity: 0, visibility: hidden)
- Fades in when hovering over the message
- Uses Slack's "X" SVG icon
- Changes color on hover (from #616061 to #1d1c1d)
- Has a subtle background on hover (#f8f8f8)

## Dark Mode

The dark mode implementation closely matches Slack's dark theme:
- Background: #1a1d21 (Slack's dark mode color)
- Text: #e0e0e0 (light gray)
- Border: #393a3e (dark gray)
- Hover background: #222529 (slightly lighter than the background)

The avatar colors remain consistent between light and dark modes to maintain clear visual indicators.

## Accessibility Features

- **ARIA Roles**: Uses appropriate role="alert" for error/warning and role="status" for success/info
- **ARIA Live Regions**: Uses aria-live="assertive" for critical messages and aria-live="polite" for non-critical messages
- **Reduced Motion**: Respects prefers-reduced-motion media query and disables animations
- **Keyboard Access**: Close button is fully keyboard accessible
- **Color Indicators**: Each notification type has its own color, but also includes a symbol
- **Text Contrast**: Maintains good contrast ratios in both light and dark modes

## RTL Support

The theme includes comprehensive right-to-left language support:
- Swaps all directional padding and margins
- Moves the avatar to the right side
- Moves the close button to the left side
- Properly aligns text for RTL languages

## Font Considerations

For the best experience with the Slack theme, it's recommended to include the Lato font in your project:

```html
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
```

If Lato is not available, the theme falls back to Helvetica Neue or Helvetica, which provide a similar clean appearance.

## Browser Support

The Slack theme is compatible with all modern browsers:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

The theme uses standard CSS features that are well-supported across browsers, ensuring a consistent experience for all users.
