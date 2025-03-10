---
permalink: /theme/flasher/
title: Flasher Theme
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
handler: theme.flasher
data-controller: theme-flasher
---

# <i class="fa-solid fa-bolt"></i> Flasher Theme

**The default notification style for PHPFlasher**

The Flasher theme comes built-in with PHPFlasher and gives you clean, professional notifications right out of the box. Each alert has a colored border on the left that helps users quickly identify the message type (success, error, etc.).

<div class="p-4 mt-4 mb-4 border rounded-lg bg-blue-50 border-blue-200">
  <div class="flex">
    <div class="flex-shrink-0">
      <i class="fa-solid fa-circle-info text-blue-400 mt-0.5"></i>
    </div>
    <div class="ml-3">
      <p class="text-sm text-blue-700">
        <strong>Just getting started?</strong> Check out the <a href="/installation/" class="font-medium underline">installation guide</a> first to set up PHPFlasher.
      </p>
    </div>
  </div>
</div>

## <i class="fa-solid fa-wand-magic-sparkles"></i> How to Use This Theme

### The Easy Way (Default Theme)

Good news! The Flasher theme is already set up and ready to go as soon as you install PHPFlasher. You don't need to do anything special to use it.

**Just create notifications like this:**

```php
// In your PHP code
flash()->success('Your changes have been saved!');
```

```javascript
// Or in your JavaScript
flasher.success('Your changes have been saved!');
```

### Want to Make Sure It's Set as Default?

If you want to explicitly set Flasher as your default theme (maybe you've changed it before), here's how:

<div class="mb-6">
  <div class="border rounded-lg p-4 bg-gray-50 mb-4">
    <p class="mb-2">
      <i class="fa-brands fa-laravel fa-lg text-red-500 mr-2"></i>
      <strong>Laravel</strong>
    </p>
    <pre class="text-sm bg-white p-2 rounded copyable language-php"><code>// config/flasher.php

return [
    'default' => 'flasher',
    
    // Other settings...
];</code></pre>
  </div>
  
  <div class="border rounded-lg p-4 bg-gray-50">
    <p class="mb-2">
      <i class="fa-brands fa-symfony fa-lg text-black mr-2"></i>
      <strong>Symfony</strong>
    </p>
    <pre class="text-sm bg-white p-2 rounded language-yaml"><code># config/packages/flasher.yaml

flasher:
    default: flasher
    
    # Other settings...</code></pre>
  </div>
</div>

### JavaScript Setup

```javascript
// The theme is available automatically
// Just use it like this:
flasher.success('Well done!');

// Or explicitly set it as default:
flasher.defaultPlugin = 'flasher';
```

## <i class="fa-solid fa-palette"></i> Notification Types

You can create four types of notifications with different colors and icons:

{% assign successMessage = 'Operation completed successfully.' %}
{% assign errorMessage = 'An error occurred during the operation.' %}
{% assign warningMessage = 'This action cannot be undone.' %}
{% assign infoMessage = 'New updates are available.' %}

<script type="text/javascript">
    messages['#/ flasher types'] = [
        {
            handler: 'flasher',
            type: 'success',
            message: '{{ successMessage }}',
            title: 'Success'
        },
        {
            handler: 'flasher',
            type: 'error',
            message: '{{ errorMessage }}',
            title: 'Error'
        },
        {
            handler: 'flasher',
            type: 'warning',
            message: '{{ warningMessage }}',
            title: 'Warning'
        },
        {
            handler: 'flasher',
            type: 'info',
            message: '{{ infoMessage }}',
            title: 'Information'
        }
    ];
</script>

<div class="mb-6">
  <div class="border rounded-lg p-4 mb-4">
    <p class="font-bold mb-2"><i class="fa-brands fa-php text-purple-600 mr-1"></i> PHP Example</p>
    <pre class="text-sm bg-gray-50 p-2 rounded">#/ flasher types

// Create notifications
flash()->success('{{ successMessage }}', 'Success');
flash()->error('{{ errorMessage }}', 'Error');
flash()->warning('{{ warningMessage }}', 'Warning');
flash()->info('{{ infoMessage }}', 'Information');</pre>
  </div>
  
  <div class="border rounded-lg p-4">
    <p class="font-bold mb-2"><i class="fa-brands fa-js text-yellow-400 mr-1"></i> JavaScript Example</p>
    <pre class="text-sm bg-gray-50 p-2 rounded">// Create notifications
flasher.success('{{ successMessage }}', 'Success');
flasher.error('{{ errorMessage }}', 'Error');
flasher.warning('{{ warningMessage }}', 'Warning');
flasher.info('{{ infoMessage }}', 'Information');</pre>
  </div>
</div>

<div class="p-4 mb-4 border rounded-lg bg-amber-50 border-amber-200">
  <div class="flex">
    <div class="flex-shrink-0">
      <i class="fa-solid fa-lightbulb text-amber-400 mt-0.5"></i>
    </div>
    <div class="ml-3">
      <p class="text-sm text-amber-700">
        <strong>Tip:</strong> You can add a title to your notification by providing it as the second parameter.
      </p>
    </div>
  </div>
</div>

## <i class="fa-solid fa-brush"></i> Customizing Notifications

### Using This Theme for Specific Notifications

If you have a different default theme but want to use the Flasher theme for just one notification:

```php
// In PHP
flash()->use('flasher')->success('This will use the Flasher theme!');
```

```javascript
// In JavaScript
flasher.use('flasher').success('This will use the Flasher theme!');
```

### Changing the Colors

Want to customize the colors? You can override these CSS variables in your stylesheet:

```css
:root {
    /* Base colors */
    --fl-bg-light: #ffffff;            /* Light mode background */
    --fl-bg-dark: rgb(15, 23, 42);     /* Dark mode background */
    --fl-text-light: rgb(75, 85, 99);  /* Light mode text */
    --fl-text-dark: #ffffff;           /* Dark mode text */
    
    /* Type colors */
    --fl-success: #10b981;             /* Success color (green) */
    --fl-info: #3b82f6;                /* Info color (blue) */
    --fl-warning: #f59e0b;             /* Warning color (orange) */
    --fl-error: #ef4444;               /* Error color (red) */
}
```

## <i class="fa-solid fa-lightbulb"></i> Features and Benefits

<div class="mb-6">
  <div class="border rounded-lg p-4 mb-4">
    <h3 class="text-lg font-semibold mb-2"><i class="fa-solid fa-palette text-purple-500 mr-1"></i> Visual Design</h3>
    <ul class="list-disc pl-5 space-y-1 text-sm">
      <li>Colored left border for quick message identification</li>
      <li>Clean, easy-to-read typography</li>
      <li>Type-specific icons (checkmark, alert, etc.)</li>
      <li>Progress bar shows time until auto-dismiss</li>
      <li>Smooth animations for better user experience</li>
    </ul>
  </div>
  
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-2"><i class="fa-solid fa-universal-access text-blue-500 mr-1"></i> Accessibility</h3>
    <ul class="list-disc pl-5 space-y-1 text-sm">
      <li>Proper ARIA roles for screen readers</li>
      <li>High contrast text meeting WCAG standards</li>
      <li>Keyboard navigable close buttons</li>
      <li>Respects reduced motion preferences</li>
      <li>Full RTL (right-to-left) language support</li>
    </ul>
  </div>
</div>

### Dark Mode Ready

The Flasher theme automatically switches to dark mode when your user's system preference is set to dark.

## <i class="fa-solid fa-code"></i> HTML Structure

For developers who want to customize further, here's the HTML structure:

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

<div class="p-4 border rounded-lg bg-gray-50 mt-6">
  <h3 class="font-bold text-lg mb-2">Browser Support</h3>
  <p class="mb-2">The Flasher theme works in all modern browsers:</p>
  <div class="flex flex-wrap gap-3">
    <span class="px-3 py-1 bg-white rounded-full border text-sm"><i class="fa-brands fa-chrome text-green-600"></i> Chrome</span>
    <span class="px-3 py-1 bg-white rounded-full border text-sm"><i class="fa-brands fa-firefox text-orange-600"></i> Firefox</span>
    <span class="px-3 py-1 bg-white rounded-full border text-sm"><i class="fa-brands fa-safari text-blue-600"></i> Safari</span>
    <span class="px-3 py-1 bg-white rounded-full border text-sm"><i class="fa-brands fa-edge text-blue-500"></i> Edge</span>
    <span class="px-3 py-1 bg-white rounded-full border text-sm"><i class="fa-brands fa-opera text-red-600"></i> Opera</span>
    <span class="px-3 py-1 bg-white rounded-full border text-sm"><i class="fa-solid fa-mobile-screen"></i> Mobile</span>
  </div>
</div>
