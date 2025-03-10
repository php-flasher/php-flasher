---
permalink: /theme/flasher/
title: Flasher Theme
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
---

<!-- Simple Hero Section -->
<div class="border-b border-slate-200 pb-6 mb-10">
  <div class="flex items-center mb-4">
    <span class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mr-3">
      <i class="fa-solid fa-bolt text-purple-600"></i>
    </span>
    <h1 class="text-3xl font-bold text-slate-800">Flasher Theme</h1>
  </div>
  <div class="flex flex-col md:flex-row md:items-center justify-between">
    <p class="text-lg text-slate-600 max-w-lg mb-4 md:mb-0">Beautiful notifications that enhance your web applications — instantly.</p>
    <div class="flex gap-2">
      <button onclick="flasher.success('Success! Your changes were saved.', 'Well Done')" class="px-3 py-1.5 border border-slate-200 bg-white text-slate-700 rounded hover:bg-slate-50 transition-colors">
        <i class="fa-regular fa-circle-check mr-1 text-green-500"></i> Try Success
      </button>
      <button onclick="flasher.error('Something went wrong. Please try again.')" class="px-3 py-1.5 border border-slate-200 bg-white text-slate-700 rounded hover:bg-slate-50 transition-colors">
        <i class="fa-regular fa-circle-xmark mr-1 text-red-500"></i> Try Error
      </button>
    </div>
  </div>
</div>

<div class="bg-slate-50 rounded-lg border border-slate-200 p-4 mb-8">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="fl-flasher fl-success fl-container fl-show hover:-translate-y-1 transition-all duration-200 shadow-sm" role="status" aria-live="polite" aria-atomic="true">
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

    <div class="fl-flasher fl-error fl-container fl-show hover:-translate-y-1 transition-all duration-200 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
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

    <div class="fl-flasher fl-warning fl-container fl-show hover:-translate-y-1 transition-all duration-200 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
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

    <div class="fl-flasher fl-info fl-container fl-show hover:-translate-y-1 transition-all duration-200 shadow-sm" role="status" aria-live="polite" aria-atomic="true">
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

<!-- Code Examples Section -->
<h2 class="text-2xl font-semibold text-slate-800 mb-4">Quick Implementation</h2>

<div class="space-y-3 mb-8">
  <div class="rounded-lg shadow-sm border border-slate-200 p-3 bg-white">
    <div class="flex items-center">
      <span class="w-7 h-7 bg-purple-100 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
        <i class="fa-brands fa-php text-purple-600"></i>
      </span>
      <pre class="overflow-auto language-php flex-1"><code>flash()->success('Your changes have been saved!');</code></pre>
    </div>
  </div>
  
  <div class="rounded-lg shadow-sm border border-slate-200 p-3 bg-white">
    <div class="flex items-center">
      <span class="w-7 h-7 bg-amber-100 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
        <i class="fa-brands fa-js text-amber-600"></i>
      </span>
      <pre class="overflow-auto language-javascript flex-1"><code>flasher.success('Your changes have been saved!');</code></pre>
    </div>
  </div>
  
  <div class="rounded-lg shadow-sm border border-slate-200 p-3 bg-white">
    <div class="flex items-center">
      <span class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
        <i class="fa-solid fa-code text-blue-600"></i>
      </span>
      <pre class="overflow-auto language-php flex-1"><code>flash()->success('Operation completed!', 'Success Title');</code></pre>
    </div>
  </div>
</div>

<!-- Configuration Tabs -->
<h2 class="text-2xl font-semibold text-slate-800 mb-4">Configuration</h2>

<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden mb-8">
  <div class="flex border-b border-slate-200 bg-slate-50">
    <button class="tab-button px-4 py-2 text-slate-800 font-medium border-b-2 border-purple-500 focus:outline-none">Laravel</button>
    <button class="tab-button px-4 py-2 text-slate-500 hover:text-slate-800 focus:outline-none">Symfony</button>
    <button class="tab-button px-4 py-2 text-slate-500 hover:text-slate-800 focus:outline-none">JavaScript</button>
  </div>
  
  <div class="tab-content p-4">
    <div class="flex items-center mb-2 text-slate-800">
      <i class="fa-brands fa-laravel text-red-500 mr-2"></i>
      <span class="font-medium">Setting as Default in Laravel</span>
    </div>
    <pre class="language-php bg-slate-50 p-3 rounded"><code>// config/flasher.php

return [
    'default' => 'flasher',
    // Other settings...
];</code></pre>
  </div>
</div>

<!-- Features Section -->
<h2 class="text-2xl font-semibold text-slate-800 mb-6">Key Features</h2>

<div class="bg-white rounded-lg border border-slate-200 overflow-hidden shadow-sm mb-8">
  <div class="grid grid-cols-1 md:grid-cols-2">
    <div class="p-5 border-b md:border-b-0 md:border-r border-slate-200">
      <h3 class="flex items-center text-lg font-medium text-slate-800 mb-3">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-purple-100 mr-2 flex-shrink-0">
          <i class="fa-solid fa-palette text-purple-600 text-sm"></i>
        </span>
        Visual Design
      </h3>
      
      <ul class="space-y-2">
        <li class="flex items-start text-sm text-slate-600">
          <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
          <span>Color-coded borders for quick identification</span>
        </li>
        <li class="flex items-start text-sm text-slate-600">
          <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
          <span>Progress indicator shows remaining display time</span>
        </li>
        <li class="flex items-start text-sm text-slate-600">
          <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
          <span>Responsive design works on all screen sizes</span>
        </li>
      </ul>
    </div>
    
    <div class="p-5">
      <h3 class="flex items-center text-lg font-medium text-slate-800 mb-3">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 mr-2 flex-shrink-0">
          <i class="fa-solid fa-universal-access text-blue-600 text-sm"></i>
        </span>
        Accessibility
      </h3>
      
      <ul class="space-y-2">
        <li class="flex items-start text-sm text-slate-600">
          <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
          <span>Semantic ARIA attributes for screen readers</span>
        </li>
        <li class="flex items-start text-sm text-slate-600">
          <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
          <span>Keyboard navigation support</span>
        </li>
        <li class="flex items-start text-sm text-slate-600">
          <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
          <span>RTL language support</span>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- Customization Section -->
<h2 class="text-2xl font-semibold text-slate-800 mb-4">Customize the Theme</h2>

<!-- Theme Selection -->
<div class="mb-6">
  <h3 class="text-lg font-medium text-slate-800 mb-3">Theme Selection</h3>
  <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-3">
    <pre class="language-php text-sm"><code>// Use this theme for a specific notification
flash()->use('flasher')->success('This uses Flasher theme');</code></pre>
  </div>
</div>

<!-- Color Customization -->
<div class="mb-6">
  <h3 class="text-lg font-medium text-slate-800 mb-3">Color Customization</h3>
  <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-3">
    <pre class="language-css text-sm"><code>:root {
  --fl-success: #10b981; /* Green */
  --fl-error: #ef4444;   /* Red */
  --fl-warning: #f59e0b; /* Orange */
  --fl-info: #3b82f6;    /* Blue */
}</code></pre>
  </div>
</div>

<!-- Technical Details -->
<div class="mb-6">
  <h3 class="text-lg font-medium text-slate-800 mb-3">Technical Details</h3>
  <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
    <p class="text-slate-600 mb-3">The Flasher theme is well-supported across all modern browsers and devices.</p>
    
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
      <div class="p-2 bg-slate-50 rounded text-center text-xs text-slate-600">
        <i class="fa-brands fa-chrome text-lg block mb-1 text-green-600"></i>
        Chrome
      </div>
      <div class="p-2 bg-slate-50 rounded text-center text-xs text-slate-600">
        <i class="fa-brands fa-firefox text-lg block mb-1 text-orange-600"></i>
        Firefox
      </div>
      <div class="p-2 bg-slate-50 rounded text-center text-xs text-slate-600">
        <i class="fa-brands fa-safari text-lg block mb-1 text-blue-600"></i>
        Safari
      </div>
      <div class="p-2 bg-slate-50 rounded text-center text-xs text-slate-600">
        <i class="fa-brands fa-edge text-lg block mb-1 text-blue-500"></i>
        Edge
      </div>
      <div class="p-2 bg-slate-50 rounded text-center text-xs text-slate-600">
        <i class="fa-solid fa-mobile-screen text-lg block mb-1"></i>
        Mobile
      </div>
      <div class="p-2 bg-slate-50 rounded text-center text-xs text-slate-600">
        <i class="fa-solid fa-moon text-lg block mb-1 text-indigo-600"></i>
        Dark Mode
      </div>
    </div>
  </div>
</div>

<!-- HTML Structure -->
<div class="mb-6">
  <h3 class="text-lg font-medium text-slate-800 mb-3">HTML Structure</h3>
  <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-3">
    <pre class="language-html text-xs"><code>&lt;div class="fl-flasher fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
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
</div>

<!-- Help Section -->
<div class="border border-slate-200 rounded-lg p-4 flex items-center bg-white mb-8">
  <div class="mr-4 flex-shrink-0">
    <i class="fa-solid fa-circle-question text-purple-500 text-xl"></i>
  </div>
  <div>
    <h3 class="text-lg font-medium text-slate-800 mb-1">Need Help?</h3>
    <p class="text-slate-600 text-sm">
      Check out our <a href="/docs/" class="text-purple-700 underline hover:text-purple-900">documentation</a> or join our <a href="https://github.com/php-flasher/php-flasher/discussions" class="text-purple-700 underline hover:text-purple-900">community</a>.
    </p>
  </div>
</div>

<script>
// Simple tab system
document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContent = document.querySelector('.tab-content');
  const frameworkContents = {
    'Laravel': `<div class="flex items-center mb-2 text-slate-800">
      <i class="fa-brands fa-laravel text-red-500 mr-2"></i>
      <span class="font-medium">Setting as Default in Laravel</span>
    </div>
    <pre class="language-php bg-slate-50 p-3 rounded"><code>// config/flasher.php

return [
    'default' => 'flasher',
    // Other settings...
];</code></pre>`,
    'Symfony': `<div class="flex items-center mb-2 text-slate-800">
      <i class="fa-brands fa-symfony text-black mr-2"></i>
      <span class="font-medium">Setting as Default in Symfony</span>
    </div>
    <pre class="language-yaml bg-slate-50 p-3 rounded"><code># config/packages/flasher.yaml

flasher:
    default: flasher
    # Other settings...</code></pre>`,
    'JavaScript': `<div class="flex items-center mb-2 text-slate-800">
      <i class="fa-brands fa-js text-amber-500 mr-2"></i>
      <span class="font-medium">Setting as Default in JavaScript</span>
    </div>
    <pre class="language-javascript bg-slate-50 p-3 rounded"><code>// Set as default theme
flasher.defaultPlugin = 'flasher';

// Then use it
flasher.success('Well done!');</code></pre>`
  };
  
  tabButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Update active tab
      tabButtons.forEach(btn => {
        btn.classList.remove('border-purple-500', 'text-slate-800', 'font-medium');
        btn.classList.add('text-slate-500');
      });
      this.classList.add('border-b-2', 'border-purple-500', 'text-slate-800', 'font-medium');
      this.classList.remove('text-slate-500');
      
      // Update content
      const framework = this.textContent;
      tabContent.innerHTML = frameworkContents[framework];
    });
  });
});
</script>
