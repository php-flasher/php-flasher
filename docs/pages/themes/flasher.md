---
permalink: /theme/flasher/
title: Flasher Theme
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
---

<div class="pb-6 mb-8 border-b border-slate-200">
  <h1 class="text-3xl font-bold tracking-tight flex items-center mb-3">
    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 mr-3 shadow-sm">
      <i class="fa-solid fa-bolt text-white"></i>
    </span>
    Flasher Theme
  </h1>
  <p class="text-lg text-slate-600 max-w-3xl">The elegant, default notification system for PHPFlasher — designed for clarity, accessibility, and visual impact.</p>
</div>

<div class="p-5 border-l-4 border-blue-500 bg-blue-50 rounded-r-lg my-8">
  <div class="flex">
    <div class="flex-shrink-0">
      <i class="fa-solid fa-circle-info text-blue-500 text-lg"></i>
    </div>
    <div class="ml-3">
      <p class="text-blue-800">
        <span class="font-medium">New to PHPFlasher?</span> Start with the <a href="/installation/" class="text-blue-700 underline hover:text-blue-900 transition-colors">installation guide</a> before exploring themes.
      </p>
    </div>
  </div>
</div>

## Introduction

Flasher theme comes pre-installed with PHPFlasher, providing a polished notification system that works immediately. Each notification features a distinctive colored border and matching icon that helps users quickly identify message types.

<div class="p-5 bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg border border-slate-200 my-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="fl-flasher fl-success fl-container fl-show hover:translate-y-[-2px] transition-transform duration-200" role="status" aria-live="polite" aria-atomic="true">
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

        <div class="fl-flasher fl-error fl-container fl-show hover:translate-y-[-2px] transition-transform duration-200" role="alert" aria-live="assertive" aria-atomic="true">
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

        <div class="fl-flasher fl-warning fl-container fl-show hover:translate-y-[-2px] transition-transform duration-200" role="alert" aria-live="assertive" aria-atomic="true">
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

        <div class="fl-flasher fl-info fl-container fl-show hover:translate-y-[-2px] transition-transform duration-200" role="status" aria-live="polite" aria-atomic="true">
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

<h2 class="text-2xl font-semibold text-slate-800 mt-10 mb-6 pb-2 border-b border-slate-200">Quick Start</h2>

<div class="space-y-2 my-3">
  <div class="bg-white rounded shadow-sm">
    <div class="flex items-center">
      <div class="flex-shrink-0 py-3 pl-3">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-purple-100">
          <i class="fa-brands fa-php text-purple-600"></i>
        </span>
      </div>
      <div class="flex-grow p-2">
        <pre class="copyable language-php font-mono text-sm"><code>flash()->success('Your changes have been saved!');</code></pre>
      </div>
    </div>
  </div>
  
  <div class="bg-white rounded shadow-sm">
    <div class="flex items-center">
      <div class="flex-shrink-0 py-3 pl-3">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100">
          <i class="fa-brands fa-js text-amber-600"></i>
        </span>
      </div>
      <div class="flex-grow p-2">
        <pre class="language-javascript font-mono text-sm"><code>flasher.success('Your changes have been saved!');</code></pre>
      </div>
    </div>
  </div>
</div>

<h2 class="text-2xl font-semibold text-slate-800 mt-10 mb-6 pb-2 border-b border-slate-200">Configuration Options</h2>

<div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 rounded-lg border border-slate-200 mb-8">
  <h3 class="text-lg font-medium mb-4 text-slate-800">Setting as Default Theme</h3>
  
  <div class="space-y-5">
    <div class="bg-white p-4 rounded-lg border border-slate-200">
      <div class="flex items-center mb-3">
        <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-red-100 mr-2">
          <i class="fa-brands fa-laravel text-red-600 text-sm"></i>
        </span>
        <span class="font-medium">Laravel</span>
      </div>
      <pre class="language-php font-mono text-sm"><code>// config/flasher.php

return [
    'default' => 'flasher',
    // Other settings...
];</code></pre>
    </div>

    <div class="bg-white p-4 rounded-lg border border-slate-200">
      <div class="flex items-center mb-3">
        <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-gray-900 mr-2">
          <i class="fa-brands fa-symfony text-white text-sm"></i>
        </span>
        <span class="font-medium">Symfony</span>
      </div>
      <pre class="language-yaml font-mono text-sm"><code># config/packages/flasher.yaml

flasher:
    default: flasher
    # Other settings...</code></pre>
    </div>

    <div class="bg-white p-4 rounded-lg border border-slate-200">
      <div class="flex items-center mb-3">
        <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-amber-100 mr-2">
          <i class="fa-brands fa-js text-amber-600 text-sm"></i>
        </span>
        <span class="font-medium">JavaScript</span>
      </div>
      <pre class="language-javascript font-mono text-sm"><code>// Set as default theme
flasher.defaultPlugin = 'flasher';

// Then use it
flasher.success('Well done!');</code></pre>
    </div>
  </div>
</div>

<h2 class="text-2xl font-semibold text-slate-800 mt-10 mb-6 pb-2 border-b border-slate-200">Core Features</h2>

<h3 class="text-xl font-medium my-4 text-slate-800">Selective Theme Usage</h3>

<p class="mb-4 text-slate-600">If you're using multiple themes, you can selectively use the Flasher theme for specific notifications:</p>

<div class="bg-white rounded-lg border border-slate-200 p-4 my-6 shadow-sm">
  <pre class="language-php font-mono text-sm"><code>// In PHP
flash()->use('flasher')->success('This uses the Flasher theme!');</code></pre>
  
  <div class="mt-4 pt-4 border-t border-slate-100">
    <pre class="language-javascript font-mono text-sm"><code>// In JavaScript
flasher.use('flasher').success('This uses the Flasher theme!');</code></pre>
  </div>
</div>

<h2 class="text-2xl font-semibold text-slate-800 mt-10 mb-6 pb-2 border-b border-slate-200">Customization</h2>

<h3 class="text-xl font-medium my-4 text-slate-800">Color Theming</h3>

<p class="mb-4 text-slate-600">Customize the notification appearance by overriding these CSS variables:</p>

<div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm my-6">
  <pre class="language-css font-mono text-sm"><code>:root {
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

<h2 class="text-2xl font-semibold text-slate-800 mt-10 mb-6 pb-2 border-b border-slate-200">Design System</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
  <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-sm">
    <h3 class="text-lg font-medium mb-4 flex items-center text-slate-800">
      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 mr-3">
        <i class="fa-solid fa-palette text-purple-600"></i>
      </span>
      Visual Elements
    </h3>
    <ul class="space-y-2.5">
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Colored left border for quick visual identification</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Type-specific icons enhance meaning</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Visual progress bar indicates time until dismissal</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Clean typography with proper hierarchy</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Subtle animations for better user experience</span>
      </li>
    </ul>
  </div>
  
  <div class="bg-white rounded-lg p-5 border border-slate-200 shadow-sm">
    <h3 class="text-lg font-medium mb-4 flex items-center text-slate-800">
      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
        <i class="fa-solid fa-universal-access text-blue-600"></i>
      </span>
      Accessibility
    </h3>
    <ul class="space-y-2.5">
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Semantic ARIA roles for screen readers</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>WCAG-compliant contrast ratios</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Keyboard-navigable close buttons</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Respects reduced motion preferences</span>
      </li>
      <li class="flex items-start group">
        <i class="fa-solid fa-check text-green-500 mr-2.5 mt-0.5 transform transition-transform duration-200 group-hover:scale-125"></i>
        <span>Full RTL language support</span>
      </li>
    </ul>
  </div>
</div>

<h2 class="text-2xl font-semibold text-slate-800 mt-10 mb-6 pb-2 border-b border-slate-200">Technical Details</h2>

<h3 class="text-xl font-medium my-4 text-slate-800">HTML Structure</h3>

<p class="mb-4 text-slate-600">For developers looking to customize the theme, here's the HTML structure:</p>

<div class="bg-white rounded-lg border border-slate-200 p-5 shadow-sm my-6">
  <pre class="language-html font-mono text-sm"><code>&lt;div class="fl-flasher fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    &lt;div class="fl-content">
        &lt;div class="fl-icon">&lt;/div>
        &lt;div>
            &lt;strong class="fl-title">Title text&lt;/strong>
            &lt;span class="fl-message">Message text&lt;/span>
        &lt;/div>
        &lt;button class="fl-close" aria-label="Close [type] message">&times;&lt;/button>
    &lt;/div>
    &lt;span class="fl-progress-bar">
        &lt;span class="fl-progress">&lt;/span>
    &lt;/span>
&lt;/div></code></pre>
</div>

<div class="bg-white rounded-lg border border-slate-200 p-6 shadow-sm my-6">
  <h3 class="text-lg font-medium mb-4 text-slate-800">Browser Support</h3>
  <p class="text-slate-600 mb-4">The Flasher theme is compatible with all modern browsers:</p>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
    <div class="p-3 bg-slate-50 rounded-lg flex flex-col items-center justify-center">
      <i class="fa-brands fa-chrome text-green-600 text-xl mb-2"></i>
      <span class="text-sm text-slate-600">Chrome</span>
    </div>
    <div class="p-3 bg-slate-50 rounded-lg flex flex-col items-center justify-center">
      <i class="fa-brands fa-firefox-browser text-orange-600 text-xl mb-2"></i>
      <span class="text-sm text-slate-600">Firefox</span>
    </div>
    <div class="p-3 bg-slate-50 rounded-lg flex flex-col items-center justify-center">
      <i class="fa-brands fa-safari text-blue-600 text-xl mb-2"></i>
      <span class="text-sm text-slate-600">Safari</span>
    </div>
    <div class="p-3 bg-slate-50 rounded-lg flex flex-col items-center justify-center">
      <i class="fa-brands fa-edge text-blue-500 text-xl mb-2"></i>
      <span class="text-sm text-slate-600">Edge</span>
    </div>
    <div class="p-3 bg-slate-50 rounded-lg flex flex-col items-center justify-center">
      <i class="fa-brands fa-opera text-red-600 text-xl mb-2"></i>
      <span class="text-sm text-slate-600">Opera</span>
    </div>
    <div class="p-3 bg-slate-50 rounded-lg flex flex-col items-center justify-center">
      <i class="fa-solid fa-mobile-screen text-slate-600 text-xl mb-2"></i>
      <span class="text-sm text-slate-600">Mobile</span>
    </div>
  </div>
</div>

<div class="bg-gradient-to-br from-teal-50 to-green-50 border border-teal-100 rounded-lg p-5 shadow-sm mt-8">
  <div class="flex items-start">
    <div class="flex-shrink-0">
      <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-teal-100 mr-4">
        <i class="fa-solid fa-question text-teal-600"></i>
      </span>
    </div>
    <div>
      <h3 class="text-lg font-medium mb-2 text-teal-800">Need Help?</h3>
      <p class="text-teal-700">
        Explore our <a href="/docs/" class="text-teal-800 underline hover:text-teal-900 transition-colors">documentation</a> or join the <a href="https://github.com/php-flasher/php-flasher/discussions" class="text-teal-800 underline hover:text-teal-900 transition-colors">community discussions</a> for assistance.
      </p>
    </div>
  </div>
</div>
