---
permalink: /theme/flasher/
title: Flasher Theme
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
handler: theme.flasher
data-controller: theme-flasher
---

<div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-6 mb-8 text-white">
  <div class="flex items-center mb-4">
    <i class="fa-solid fa-bolt text-3xl mr-3 bg-white text-purple-600 p-2 rounded-full"></i>
    <h1 class="text-3xl font-bold tracking-tight">Flasher Theme</h1>
  </div>
  <p class="text-lg">The sleek, elegant default notification style for PHPFlasher</p>
</div>

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

## <div class="flex items-center"><i class="fa-solid fa-wand-magic-sparkles text-purple-500 mr-2"></i> Getting Started</div>

### <span class="text-green-600">The Easy Way (Default Theme)</span>

Good news! The Flasher theme is already configured as the default when you install PHPFlasher. You don't need to do anything special to start using it.

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 my-6">
  <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-lg border border-purple-100 p-5 shadow-sm">
    <div class="mb-3 flex items-center">
      <i class="fa-brands fa-php text-purple-600 text-xl mr-2"></i>
      <span class="font-bold text-purple-800">PHP</span>
    </div>
    <div class="bg-white rounded-md p-3 shadow-sm">
      ```php
      // In your controller or any PHP file
      flash()->success('Your changes have been saved!');
      ```
    </div>
  </div>
  
  <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-lg border border-amber-100 p-5 shadow-sm">
    <div class="mb-3 flex items-center">
      <i class="fa-brands fa-js text-amber-500 text-xl mr-2"></i>
      <span class="font-bold text-amber-800">JavaScript</span>
    </div>
    <div class="bg-white rounded-md p-3 shadow-sm">
      ```javascript
      // In your JavaScript file
      flasher.success('Your changes have been saved!');
      ```
    </div>
  </div>
</div>

### <span class="text-blue-600">Setting Flasher as Default Theme</span>

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
        ```php
        // config/flasher.php
        
        return [
            'default' => 'flasher',
            
            // Other settings...
        ];
        ```
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
        ```yaml
        # config/packages/flasher.yaml
        
        flasher:
            default: flasher
            
            # Other settings...
        ```
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
        ```javascript
        // The theme is available automatically
        flasher.success('Well done!');
        
        // Or explicitly set it as default:
        flasher.defaultPlugin = 'flasher';
        ```
      </div>
    </div>
  </div>
</div>

## <div class="flex items-center"><i class="fa-solid fa-palette text-pink-500 mr-2"></i> Notification Types</div>

<div class="p-5 mt-4 mb-6 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 shadow-sm">
  <p class="mb-4 text-slate-700">The Flasher theme provides four distinct notification types, each with its own color scheme and icon:</p>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white rounded-lg border-l-4 border-green-500 p-4 shadow-sm flex">
      <i class="fa-solid fa-circle-check text-green-500 text-xl mt-1 mr-3"></i>
      <div>
        <p class="font-bold text-green-800">Success</p>
        <p class="text-slate-600 text-sm">For successful operations and positive feedback</p>
      </div>
    </div>
    
    <div class="bg-white rounded-lg border-l-4 border-red-500 p-4 shadow-sm flex">
      <i class="fa-solid fa-circle-xmark text-red-500 text-xl mt-1 mr-3"></i>
      <div>
        <p class="font-bold text-red-800">Error</p>
        <p class="text-slate-600 text-sm">For errors and operations that failed</p>
      </div>
    </div>
    
    <div class="bg-white rounded-lg border-l-4 border-amber-500 p-4 shadow-sm flex">
      <i class="fa-solid fa-triangle-exclamation text-amber-500 text-xl mt-1 mr-3"></i>
      <div>
        <p class="font-bold text-amber-800">Warning</p>
        <p class="text-slate-600 text-sm">For important notices and cautions</p>
      </div>
    </div>
    
    <div class="bg-white rounded-lg border-l-4 border-blue-500 p-4 shadow-sm flex">
      <i class="fa-solid fa-circle-info text-blue-500 text-xl mt-1 mr-3"></i>
      <div>
        <p class="font-bold text-blue-800">Info</p>
        <p class="text-slate-600 text-sm">For general information and updates</p>
      </div>
    </div>
  </div>
</div>

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

<div class="mb-8 space-y-6">
  <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-4 py-2 text-white flex items-center">
      <i class="fa-brands fa-php text-xl mr-2"></i>
      <span class="font-bold">PHP Example</span>
      <div class="ml-auto">
        <button class="copy-btn bg-white text-purple-700 px-3 py-1 rounded-full text-xs font-medium hover:bg-purple-100 transition-colors" data-target="php-example">Copy Code</button>
      </div>
    </div>
    <div class="p-4 bg-white">
      <div id="php-example" class="bg-slate-50 p-4 rounded-lg relative">
        <div class="absolute top-2 right-2 text-xs text-slate-400">#/ flasher types</div>
        ```php
        // Create notifications
        flash()->success('{{ successMessage }}', 'Success');
        flash()->error('{{ errorMessage }}', 'Error');
        flash()->warning('{{ warningMessage }}', 'Warning');
        flash()->info('{{ infoMessage }}', 'Information');
        ```
      </div>
    </div>
  </div>
  
  <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
    <div class="bg-gradient-to-r from-yellow-500 to-amber-600 px-4 py-2 text-white flex items-center">
      <i class="fa-brands fa-js text-xl mr-2"></i>
      <span class="font-bold">JavaScript Example</span>
      <div class="ml-auto">
        <button class="copy-btn bg-white text-amber-700 px-3 py-1 rounded-full text-xs font-medium hover:bg-amber-100 transition-colors" data-target="js-example">Copy Code</button>
      </div>
    </div>
    <div class="p-4 bg-white">
      <div id="js-example" class="bg-slate-50 p-4 rounded-lg">
        ```javascript
        // Create notifications
        flasher.success('{{ successMessage }}', 'Success');
        flasher.error('{{ errorMessage }}', 'Error');
        flasher.warning('{{ warningMessage }}', 'Warning');
        flasher.info('{{ infoMessage }}', 'Information');
        ```
      </div>
    </div>
  </div>
</div>

<div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-lg shadow-sm mb-8">
  <div class="flex">
    <div class="flex-shrink-0">
      <i class="fa-solid fa-lightbulb text-amber-500 text-xl"></i>
    </div>
    <div class="ml-4">
      <p class="text-amber-800">
        <span class="font-semibold">Tip:</span> You can add a title to your notification by providing it as the second parameter. This makes your notifications more descriptive and helps users understand the context at a glance.
      </p>
    </div>
  </div>
</div>

<div class="bg-indigo-50 border rounded-lg p-5 my-6 shadow-sm">
  <h3 class="text-lg font-bold text-indigo-800 mb-3 flex items-center">
    <i class="fa-solid fa-eye text-indigo-600 mr-2"></i> Live Preview
  </h3>
  <p class="text-indigo-700 mb-4">Click the buttons below to see how each notification type looks:</p>
  
  <div class="flex flex-wrap gap-3">
    <button onclick="flasher.success('{{ successMessage }}', 'Success')" class="px-4 py-2 bg-white border border-green-200 text-green-700 rounded-lg hover:bg-green-50 transition-colors shadow-sm">
      <i class="fa-solid fa-circle-check mr-1"></i> Success
    </button>
    
    <button onclick="flasher.error('{{ errorMessage }}', 'Error')" class="px-4 py-2 bg-white border border-red-200 text-red-700 rounded-lg hover:bg-red-50 transition-colors shadow-sm">
      <i class="fa-solid fa-circle-xmark mr-1"></i> Error
    </button>
    
    <button onclick="flasher.warning('{{ warningMessage }}', 'Warning')" class="px-4 py-2 bg-white border border-amber-200 text-amber-700 rounded-lg hover:bg-amber-50 transition-colors shadow-sm">
      <i class="fa-solid fa-triangle-exclamation mr-1"></i> Warning
    </button>
    
    <button onclick="flasher.info('{{ infoMessage }}', 'Information')" class="px-4 py-2 bg-white border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
      <i class="fa-solid fa-circle-info mr-1"></i> Info
    </button>
  </div>
</div>

## <div class="flex items-center"><i class="fa-solid fa-brush text-teal-500 mr-2"></i> Customizing Notifications</div>

### Using Flasher Theme for Specific Notifications

If you have a different default theme but want to use the Flasher theme for just one notification:

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 my-6">
  <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
    <p class="font-semibold text-slate-700 mb-2 flex items-center">
      <i class="fa-brands fa-php text-purple-500 mr-2"></i> PHP
    </p>
    <div class="bg-slate-50 rounded p-3">
      ```php
      flash()->use('flasher')->success('This will use the Flasher theme!');
      ```
    </div>
  </div>
  
  <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-sm">
    <p class="font-semibold text-slate-700 mb-2 flex items-center">
      <i class="fa-brands fa-js text-amber-500 mr-2"></i> JavaScript
    </p>
    <div class="bg-slate-50 rounded p-3">
      ```javascript
      flasher.use('flasher').success('This will use the Flasher theme!');
      ```
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
  </div>
</div>

## <div class="flex items-center"><i class="fa-solid fa-star text-amber-500 mr-2"></i> Features and Benefits</div>

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

### <div class="flex items-center"><i class="fa-solid fa-moon text-indigo-500 mr-2"></i> Dark Mode Support</div>

<div class="bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-lg p-5 shadow-md my-6">
  <div class="flex items-start">
    <i class="fa-solid fa-moon text-blue-400 text-2xl mr-3 mt-1"></i>
    <div>
      <h3 class="text-lg font-bold mb-2">Dark Mode Ready</h3>
      <p>The Flasher theme automatically detects your user's system preference and switches to dark mode when appropriate, providing a consistent experience that matches their environment.</p>
    </div>
  </div>
</div>

## <div class="flex items-center"><i class="fa-solid fa-code text-slate-700 mr-2"></i> HTML Structure</div>

For developers who want to customize further, here's the HTML structure of the notifications:

<div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm my-6">
  <p class="font-semibold text-slate-700 mb-3">Understanding the DOM structure</p>
  <div class="bg-slate-50 rounded p-4 overflow-x-auto">
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
  </div>
</div>

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

<script>
// Add copy functionality for code blocks
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.copy-btn').forEach(button => {
    button.addEventListener('click', function() {
      const targetId = this.getAttribute('data-target');
      const codeBlock = document.getElementById(targetId);
      const code = codeBlock.querySelector('code').innerText;
      
      navigator.clipboard.writeText(code).then(() => {
        const originalText = this.innerText;
        this.innerText = 'Copied!';
        this.classList.add('bg-green-100', 'text-green-700');
        
        setTimeout(() => {
          this.innerText = originalText;
          this.classList.remove('bg-green-100', 'text-green-700');
        }, 2000);
      });
    });
  });
});
</script>
