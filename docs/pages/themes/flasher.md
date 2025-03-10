---
permalink: /theme/flasher/
title: Flasher Theme
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
handler: theme.flasher
data-controller: theme-flasher
---

# <i class="fa-solid fa-bolt text-purple-600 mr-2"></i> Flasher Theme

<p class="text-lg text-gray-700 mb-6">The sleek, elegant default notification style for PHPFlasher</p>

The Flasher theme comes built-in with PHPFlasher, providing professional notifications right out of the box. Each alert features a colored border that helps users quickly identify the message type (success, error, etc.).

<div class="p-5 mt-6 mb-6 border-l-4 border-blue-500 bg-blue-50 rounded-r-lg shadow-sm">
  <div class="flex">
    <div class="flex-shrink-0">
      <i class="fa-solid fa-circle-info text-blue-500 text-xl"></i>
    </div>
    <div class="ml-4">
      <p class="text-blue-800">
        <span class="font-semibold">Just getting started?</span> Check out the <a href="/installation/" class="text-blue-600 underline hover:text-blue-800 transition-colors">installation guide</a> first to set up PHPFlasher.
      </p>
    </div>
  </div>
</div>

## <i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> Getting Started

Good news! The Flasher theme is already configured as the default when you install PHPFlasher. You don't need to do anything special to start using it.

<div class="grid grid-cols-1 md:grid-cols-1 gap-5 my-6">
  <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg border border-purple-100 p-5 shadow-sm">
    <div class="mb-3 flex items-center">
      <i class="fa-brands fa-php text-purple-600 text-xl mr-2"></i>
      <span class="font-bold text-purple-800">PHP</span>
    </div>
    <div class="bg-white rounded-md p-3 shadow-sm">
      <pre class="copyable language-php"><code>flash()->success('Your changes have been saved!');</code></pre>
    </div>
  </div>
  
  <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-lg border border-amber-100 p-5 shadow-sm">
    <div class="mb-3 flex items-center">
      <i class="fa-brands fa-js text-amber-500 text-xl mr-2"></i>
      <span class="font-bold text-amber-800">JavaScript</span>
    </div>
    <div class="bg-white rounded-md p-3 shadow-sm">
      <pre class="language-javascript"><code>flasher.success('Your changes have been saved!');</code></pre>
    </div>
  </div>
</div>

### <i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> Setting Flasher as Default Theme

If you want to explicitly set Flasher as your default theme, here's how:

<div class="space-y-6 my-6">
  <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
    <div class="bg-gradient-to-r from-red-500 to-pink-500 px-4 py-3 text-white">
      <div class="flex items-center">
        <i class="fa-brands fa-laravel text-2xl mr-2"></i>
        <span class="font-bold">Laravel Configuration</span>
      </div>
    </div>
    <div class="p-4 bg-white">
      <div class="bg-slate-50 p-4 rounded-lg">
        <pre class="language-php"><code>// config/flasher.php

return [
    'default' => 'flasher',
    
    // Other settings...
];</code></pre>
      </div>
    </div>
  </div>
  
  <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
    <div class="bg-gradient-to-r from-gray-700 to-gray-900 px-4 py-3 text-white">
      <div class="flex items-center">
        <i class="fa-brands fa-symfony text-2xl mr-2"></i>
        <span class="font-bold">Symfony Configuration</span>
      </div>
    </div>
    <div class="p-4 bg-white">
      <div class="bg-slate-50 p-4 rounded-lg">
        <pre class="language-yaml"><code># config/packages/flasher.yaml

flasher:
    default: flasher
    
    # Other settings...</code></pre>
      </div>
    </div>
  </div>
  
  <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
    <div class="bg-gradient-to-r from-yellow-400 to-amber-500 px-4 py-3 text-white">
      <div class="flex items-center">
        <i class="fa-brands fa-js text-2xl mr-2"></i>
        <span class="font-bold">JavaScript Configuration</span>
      </div>
    </div>
    <div class="p-4 bg-white">
      <div class="bg-slate-50 p-4 rounded-lg">
        <pre class="language-javascript"><code>// explicitly set it as default:
flasher.defaultPlugin = 'flasher';

// The theme is available automatically
flasher.success('Well done!');
</code></pre>
      </div>
    </div>
  </div>
</div>

### <i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> Notification Types

<div class="p-5 mt-4 mb-6 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 shadow-sm">
    <p class="mb-4 text-slate-700">The Flasher theme provides four distinct notification types, each with its own color
        scheme and icon:</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="fl-flasher fl-success fl-container fl-show" role="status" aria-live="polite" aria-atomic="true">
            <div class="fl-content">
                <div class="fl-icon"></div>
                <div>
                    <strong class="fl-title">Success</strong>
                    <span class="fl-message">Data has been saved successfully!</span>
                </div>
                <button class="fl-close" aria-label="Close success message">×</button>
            </div>
            <span class="fl-progress-bar">
                <span class="fl-progress" style="width: 40%;"></span>
            </span>
        </div>

        <div class="fl-flasher fl-error fl-container fl-show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="fl-content">
                <div class="fl-icon"></div>
                <div>
                    <strong class="fl-title">Error</strong>
                    <span class="fl-message">Oops! Something went wrong!</span>
                </div>
                <button class="fl-close" aria-label="Close error message">×</button>
            </div>
            <span class="fl-progress-bar">
                <span class="fl-progress" style="width: 25%;"></span>
            </span>
        </div>

        <div class="fl-flasher fl-warning fl-container fl-show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="fl-content">
                <div class="fl-icon"></div>
                <div>
                    <strong class="fl-title">Warning</strong>
                    <span class="fl-message">Are you sure you want to proceed?</span>
                </div>
                <button class="fl-close" aria-label="Close warning message">×</button>
            </div>
            <span class="fl-progress-bar">
                <span class="fl-progress" style="width: 10%;"></span>
            </span>
        </div>

        <div class="fl-flasher fl-info fl-container fl-show" role="status" aria-live="polite" aria-atomic="true">
            <div class="fl-content">
                <div class="fl-icon"></div>
                <div>
                    <strong class="fl-title">Information</strong>
                    <span class="fl-message">Welcome back!</span>
                </div>
                <button class="fl-close" aria-label="Close info message">×</button>
            </div>
            <span class="fl-progress-bar">
                <span class="fl-progress" style="width: 5%;"></span>
            </span>
        </div>
    </div>
</div>

### <i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> Customizing Notifications

### Using Flasher Theme for Specific Notifications

If you have a different default theme but want to use the Flasher theme for just one notification:

<div class="grid grid-cols-1 md:grid-cols-1 gap-5 my-6">
  <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
    <p class="font-semibold text-slate-700 mb-2 flex items-center">
      <i class="fa-brands fa-php text-purple-500 mr-2"></i> PHP
    </p>
    <div class="bg-slate-50 rounded p-3">
      <pre class="language-php"><code>flash()->use('flasher')->success('This will use the Flasher theme!');</code></pre>
    </div>
  </div>
  
  <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
    <p class="font-semibold text-slate-700 mb-2 flex items-center">
      <i class="fa-brands fa-js text-amber-500 mr-2"></i> JavaScript
    </p>
    <div class="bg-slate-50 rounded p-3">
      <pre class="language-javascript"><code>flasher.use('flasher').success('This will use the Flasher theme!');</code></pre>
    </div>
  </div>
</div>

### Changing the Colors

You can customize the appearance of your notifications by overriding these CSS variables in your stylesheet:

<div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm my-6">
  <p class="font-semibold text-slate-700 mb-3 flex items-center">
    <i class="fa-solid fa-palette text-pink-500 mr-2"></i> Custom Colors
  </p>
  <div class="bg-slate-50 rounded p-4">
    <pre class="language-css"><code>:root {
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
}</code></pre>
  </div>
</div>

### <i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> Features and Benefits

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
  <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg p-5 border border-purple-100 shadow-sm">
    <h3 class="text-lg font-bold text-purple-800 mb-3 flex items-center">
      <i class="fa-solid fa-palette text-purple-600 mr-2"></i> Visual Design
    </h3>
    <ul class="space-y-2">
      <li class="flex items-start">
        <i class="fa-solid fa-check text-purple-500 mr-2 mt-1"></i>
        <span>Colored left border for quick message identification</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-purple-500 mr-2 mt-1"></i>
        <span>Clean, easy-to-read typography</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-purple-500 mr-2 mt-1"></i>
        <span>Type-specific icons (checkmark, alert, etc.)</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-purple-500 mr-2 mt-1"></i>
        <span>Progress bar shows time until auto-dismiss</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-purple-500 mr-2 mt-1"></i>
        <span>Smooth animations for better user experience</span>
      </li>
    </ul>
  </div>
  
  <div class="bg-gradient-to-br from-blue-50 to-sky-50 rounded-lg p-5 border border-blue-100 shadow-sm">
    <h3 class="text-lg font-bold text-blue-800 mb-3 flex items-center">
      <i class="fa-solid fa-universal-access text-blue-600 mr-2"></i> Accessibility
    </h3>
    <ul class="space-y-2">
      <li class="flex items-start">
        <i class="fa-solid fa-check text-blue-500 mr-2 mt-1"></i>
        <span>Proper ARIA roles for screen readers</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-blue-500 mr-2 mt-1"></i>
        <span>High contrast text meeting WCAG standards</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-blue-500 mr-2 mt-1"></i>
        <span>Keyboard navigable close buttons</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-blue-500 mr-2 mt-1"></i>
        <span>Respects reduced motion preferences</span>
      </li>
      <li class="flex items-start">
        <i class="fa-solid fa-check text-blue-500 mr-2 mt-1"></i>
        <span>Full RTL (right-to-left) language support</span>
      </li>
    </ul>
  </div>
</div>

### <i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> HTML Structure

For developers who want to customize further, here's the HTML structure of the notifications:

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

<div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg border border-slate-200 p-6 shadow-sm mt-8">
  <h3 class="text-xl font-bold text-slate-800 mb-4">Browser Support</h3>
  <p class="text-slate-700 mb-4">The Flasher theme works seamlessly across all modern browsers:</p>
  <div class="flex flex-wrap gap-3">
    <span class="px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm flex items-center">
      <i class="fa-brands fa-chrome text-green-600 text-lg mr-2"></i> Chrome
    </span>
    <span class="px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm flex items-center">
      <i class="fa-brands fa-firefox text-orange-600 text-lg mr-2"></i> Firefox
    </span>
    <span class="px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm flex items-center">
      <i class="fa-brands fa-safari text-blue-600 text-lg mr-2"></i> Safari
    </span>
    <span class="px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm flex items-center">
      <i class="fa-brands fa-edge text-blue-500 text-lg mr-2"></i> Edge
    </span>
    <span class="px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm flex items-center">
      <i class="fa-brands fa-opera text-red-600 text-lg mr-2"></i> Opera
    </span>
    <span class="px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm flex items-center">
      <i class="fa-solid fa-mobile-screen text-slate-600 text-lg mr-2"></i> Mobile
    </span>
  </div>
</div>

<div class="p-5 mt-8 mb-4 rounded-lg bg-teal-50 border border-teal-200 shadow-sm">
  <div class="flex">
    <div class="flex-shrink-0">
      <i class="fa-solid fa-question-circle text-teal-500 text-2xl"></i>
    </div>
    <div class="ml-4">
      <h3 class="text-lg font-bold text-teal-700">Need Help?</h3>
      <p class="text-teal-600">
        If you have questions or need assistance with PHPFlasher, check out our 
        <a href="/docs/" class="text-teal-700 underline hover:text-teal-900 transition-colors">documentation</a> 
        or join our <a href="https://github.com/php-flasher/php-flasher/discussions" class="text-teal-700 underline hover:text-teal-900 transition-colors">community discussions</a>.
      </p>
    </div>
  </div>
</div>
