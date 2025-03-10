---
permalink: /theme/flasher/
title: Flasher Theme
description: The default notification theme for PHPFlasher with a clean design, colored borders, and accessible notifications for your web applications.
---

<!-- Compact Hero Section -->
<header class="flex items-center justify-between pb-3 mb-5 border-b border-slate-100">
  <div class="flex items-center">
    <span class="w-8 h-8 rounded-md bg-slate-100 flex-shrink-0 flex items-center justify-center mr-2">
      <i class="fa-solid fa-bolt text-purple-600"></i>
    </span>
    <div>
      <h1 class="text-xl font-medium text-slate-800">Flasher Theme</h1>
      <p class="text-sm text-slate-500">The default notification system for PHPFlasher</p>
    </div>
  </div>
  <div class="hidden sm:flex gap-2">
    <button onclick="flasher.success('Success! Your changes were saved.', 'Well Done')" class="px-2 py-1 text-xs border border-slate-200 bg-white text-slate-700 rounded hover:bg-slate-50 transition">
      <i class="fa-regular fa-circle-check text-green-500 mr-1"></i> Try Success
    </button>
    <button onclick="flasher.error('Something went wrong. Please try again.')" class="px-2 py-1 text-xs border border-slate-200 bg-white text-slate-700 rounded hover:bg-slate-50 transition">
      <i class="fa-regular fa-circle-xmark text-red-500 mr-1"></i> Try Error
    </button>
  </div>
</header>

<!-- Demo buttons for mobile -->
<div class="sm:hidden flex gap-2 mb-4">
  <button onclick="flasher.success('Success! Your changes were saved.', 'Well Done')" class="flex-1 px-2 py-1 text-xs border border-slate-200 bg-white text-slate-700 rounded hover:bg-slate-50 transition">
    <i class="fa-regular fa-circle-check text-green-500 mr-1"></i> Try Success
  </button>
  <button onclick="flasher.error('Something went wrong. Please try again.')" class="flex-1 px-2 py-1 text-xs border border-slate-200 bg-white text-slate-700 rounded hover:bg-slate-50 transition">
    <i class="fa-regular fa-circle-xmark text-red-500 mr-1"></i> Try Error
  </button>
</div>

<!-- Notification Examples (without header) -->
<section class="bg-white rounded border border-slate-200 overflow-hidden mb-4">
  <div class="p-3 grid grid-cols-1 md:grid-cols-2 gap-3">
    <div class="fl-flasher fl-success fl-container fl-show hover:-translate-y-0.5 transition-all duration-200" role="status" aria-live="polite" aria-atomic="true">
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

    <div class="fl-flasher fl-error fl-container fl-show hover:-translate-y-0.5 transition-all duration-200" role="alert" aria-live="assertive" aria-atomic="true">
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

    <div class="fl-flasher fl-warning fl-container fl-show hover:-translate-y-0.5 transition-all duration-200" role="alert" aria-live="assertive" aria-atomic="true">
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

    <div class="fl-flasher fl-info fl-container fl-show hover:-translate-y-0.5 transition-all duration-200" role="status" aria-live="polite" aria-atomic="true">
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
</section>

<!-- Configuration Section -->
<section class="mb-4">
  <div class="flex items-center mb-2">
    <h2 class="text-sm font-medium text-slate-800">Configuration</h2>
    <div class="h-px bg-slate-200 flex-grow ml-2"></div>
  </div>
  
  <div class="bg-white rounded border border-slate-200 overflow-hidden">
    <div class="flex border-b border-slate-100 bg-slate-50 overflow-x-auto">
      <button class="tab-button px-3 py-1.5 text-slate-800 font-medium border-b-2 border-purple-500 whitespace-nowrap focus:outline-none text-xs">Laravel</button>
      <button class="tab-button px-3 py-1.5 text-slate-500 hover:text-slate-700 whitespace-nowrap focus:outline-none text-xs">Symfony</button>
      <button class="tab-button px-3 py-1.5 text-slate-500 hover:text-slate-700 whitespace-nowrap focus:outline-none text-xs">JavaScript</button>
    </div>
    
    <div class="tab-content p-3">
      <div class="flex items-center mb-1.5 text-slate-800">
        <i class="fa-brands fa-laravel text-red-500 mr-1.5"></i>
        <span class="text-xs font-medium">Setting as Default in Laravel</span>
      </div>
      <pre class="language-php bg-slate-50 p-2 rounded text-xs"><code>// config/flasher.php

return [
    'default' => 'flasher',
    // Other settings...
];</code></pre>
    </div>
  </div>
</section>

<!-- Theme Usage -->
<section class="mb-4">
  <div class="flex items-center mb-2">
    <h2 class="text-sm font-medium text-slate-800">Theme Usage</h2>
    <div class="h-px bg-slate-200 flex-grow ml-2"></div>
  </div>
  
  <div class="bg-white rounded border border-slate-200 p-3">
    <div class="flex items-center text-xs text-slate-500 mb-1.5">
      <i class="fa-solid fa-code-compare mr-1.5"></i> When set as default theme
    </div>
    <pre class="language-php text-xs mb-3"><code>// When 'flasher' is configured as your default theme
// You can call directly without specifying the theme
flash()->success('Your changes have been saved!');</code></pre>
    
    <div class="flex items-center text-xs text-slate-500 mb-1.5">
      <i class="fa-solid fa-wand-magic-sparkles mr-1.5 text-purple-500"></i> For specific notifications
    </div>
    <pre class="language-php text-xs mb-3"><code>// To use Flasher theme for just this notification
// (when another theme is your default)
flash()->use('flasher')->success('This uses Flasher theme');</code></pre>
    
    <div class="flex items-center text-xs text-slate-500 mb-1.5">
      <i class="fa-brands fa-js mr-1.5 text-amber-500"></i> JavaScript equivalent
    </div>
    <pre class="language-javascript text-xs"><code>// Default usage
flasher.success('Your changes have been saved!');

// Specific theme usage
flasher.use('flasher').success('This uses Flasher theme');</code></pre>
  </div>
</section>

<!-- Features Grid (restored previous design) -->
<section class="mb-4">
  <div class="flex items-center mb-2">
    <h2 class="text-sm font-medium text-slate-800">Key Features</h2>
    <div class="h-px bg-slate-200 flex-grow ml-2"></div>
  </div>
  
  <div class="bg-white rounded border border-slate-200 overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2">
      <div class="p-4 border-b md:border-b-0 md:border-r border-slate-100">
        <div class="flex items-center mb-3">
          <span class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center mr-2">
            <i class="fa-solid fa-palette text-purple-500 text-xs"></i>
          </span>
          <h3 class="font-medium text-slate-700 text-xs">Visual Design</h3>
        </div>
        
        <ul class="space-y-2 pl-8">
          <li class="flex items-start text-xs text-slate-600 relative">
            <i class="fa-solid fa-check text-green-500 absolute -left-5 mt-0.5"></i>
            <span>Color-coded borders for quick identification</span>
          </li>
          <li class="flex items-start text-xs text-slate-600 relative">
            <i class="fa-solid fa-check text-green-500 absolute -left-5 mt-0.5"></i>
            <span>Progress indicator shows remaining display time</span>
          </li>
          <li class="flex items-start text-xs text-slate-600 relative">
            <i class="fa-solid fa-check text-green-500 absolute -left-5 mt-0.5"></i>
            <span>Responsive design works on all screen sizes</span>
          </li>
        </ul>
      </div>
      
      <div class="p-4">
        <div class="flex items-center mb-3">
          <span class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mr-2">
            <i class="fa-solid fa-universal-access text-blue-500 text-xs"></i>
          </span>
          <h3 class="font-medium text-slate-700 text-xs">Accessibility</h3>
        </div>
        
        <ul class="space-y-2 pl-8">
          <li class="flex items-start text-xs text-slate-600 relative">
            <i class="fa-solid fa-check text-green-500 absolute -left-5 mt-0.5"></i>
            <span>Semantic ARIA attributes for screen readers</span>
          </li>
          <li class="flex items-start text-xs text-slate-600 relative">
            <i class="fa-solid fa-check text-green-500 absolute -left-5 mt-0.5"></i>
            <span>Keyboard navigation support</span>
          </li>
          <li class="flex items-start text-xs text-slate-600 relative">
            <i class="fa-solid fa-check text-green-500 absolute -left-5 mt-0.5"></i>
            <span>RTL language support</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Customization Section -->
<section class="mb-4">
  <div class="flex items-center mb-2">
    <h2 class="text-sm font-medium text-slate-800">Customization</h2>
    <div class="h-px bg-slate-200 flex-grow ml-2"></div>
  </div>
  
  <!-- Color Customization (without header) -->
  <div class="mb-3">
    <div class="bg-white rounded border border-slate-200 p-3">
      <div class="flex items-center text-xs text-slate-500 mb-1.5">
        <i class="fa-solid fa-palette text-slate-400 mr-1.5"></i> CSS Variables
      </div>
      <pre class="language-css text-xs"><code>:root {
  --fl-success: #10b981; /* Green */
  --fl-error: #ef4444;   /* Red */
  --fl-warning: #f59e0b; /* Orange */
  --fl-info: #3b82f6;    /* Blue */
}</code></pre>
    </div>
  </div>

  <!-- HTML Structure (without header) -->
  <div class="mb-3">
    <div class="bg-white rounded border border-slate-200 p-3">
      <div class="flex items-center text-xs text-slate-500 mb-1.5">
        <i class="fa-solid fa-code text-slate-400 mr-1.5"></i> HTML Structure
      </div>
      <pre class="language-html text-xs"><code>&lt;div class="fl-flasher fl-[type]" role="[role]" aria-live="[ariaLive]" aria-atomic="true">
    &lt;div class="fl-content">
        &lt;div class="fl-icon">&lt;/div>
        &lt;div>
            &lt;strong class="fl-title">Title text&lt;/strong>
            &lt;span class="fl-message">Message text&lt;/span>
        &lt;/div>
        &lt;button class="fl-close" aria-label="Close">&times;&lt;/button>
    &lt;/div>
    &lt;span class="fl-progress-bar">
        &lt;span class="fl-progress">&lt;/span>
    &lt;/span>
&lt;/div></code></pre>
    </div>
  </div>
</section>

<!-- Browser Support (horizontal layout) -->
<section class="mb-4">
  <div class="flex items-center mb-2">
    <h2 class="text-sm font-medium text-slate-800">Browser Support</h2>
    <div class="h-px bg-slate-200 flex-grow ml-2"></div>
  </div>
  
  <div class="bg-white rounded border border-slate-200 p-3 flex flex-wrap justify-around">
    <div class="flex flex-col items-center p-1">
      <i class="fa-brands fa-chrome text-base text-green-600"></i>
      <span class="text-[10px] mt-0.5 text-slate-500">Chrome</span>
    </div>
    <div class="flex flex-col items-center p-1">
      <i class="fa-brands fa-firefox text-base text-orange-600"></i>
      <span class="text-[10px] mt-0.5 text-slate-500">Firefox</span>
    </div>
    <div class="flex flex-col items-center p-1">
      <i class="fa-brands fa-safari text-base text-blue-600"></i>
      <span class="text-[10px] mt-0.5 text-slate-500">Safari</span>
    </div>
    <div class="flex flex-col items-center p-1">
      <i class="fa-brands fa-edge text-base text-blue-500"></i>
      <span class="text-[10px] mt-0.5 text-slate-500">Edge</span>
    </div>
    <div class="flex flex-col items-center p-1">
      <i class="fa-solid fa-mobile-screen text-base"></i>
      <span class="text-[10px] mt-0.5 text-slate-500">Mobile</span>
    </div>
    <div class="flex flex-col items-center p-1">
      <i class="fa-solid fa-moon text-base text-indigo-600"></i>
      <span class="text-[10px] mt-0.5 text-slate-500">Dark</span>
    </div>
  </div>
</section>

<!-- Help Section -->
<div class="border border-slate-200 rounded p-2 flex items-center bg-white">
  <div class="mr-2 flex-shrink-0">
    <div class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center">
      <i class="fa-solid fa-question text-purple-500 text-xs"></i>
    </div>
  </div>
  <div>
    <h3 class="text-xs font-medium text-slate-800">Need help?</h3>
    <p class="text-[10px] text-slate-600">
      Check our <a href="/docs/" class="text-purple-600 hover:text-purple-800">documentation</a> or join our <a href="https://github.com/php-flasher/php-flasher/discussions" class="text-purple-600 hover:text-purple-800">community</a>.
    </p>
  </div>
</div>

<script>
// Tab system with Prism re-highlight
document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContent = document.querySelector('.tab-content');
  const frameworkContents = {
    'Laravel': `<div class="flex items-center mb-1.5 text-slate-800">
      <i class="fa-brands fa-laravel text-red-500 mr-1.5"></i>
      <span class="text-xs font-medium">Setting as Default in Laravel</span>
    </div>
    <pre class="language-php bg-slate-50 p-2 rounded text-xs"><code>// config/flasher.php

return [
    'default' => 'flasher',
    // Other settings...
];</code></pre>`,
    'Symfony': `<div class="flex items-center mb-1.5 text-slate-800">
      <i class="fa-brands fa-symfony text-black mr-1.5"></i>
      <span class="text-xs font-medium">Setting as Default in Symfony</span>
    </div>
    <pre class="language-yaml bg-slate-50 p-2 rounded text-xs"><code># config/packages/flasher.yaml

flasher:
    default: flasher
    # Other settings...</code></pre>`,
    'JavaScript': `<div class="flex items-center mb-1.5 text-slate-800">
      <i class="fa-brands fa-js text-amber-500 mr-1.5"></i>
      <span class="text-xs font-medium">Setting as Default in JavaScript</span>
    </div>
    <pre class="language-javascript bg-slate-50 p-2 rounded text-xs"><code>// Set as default theme
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
      
      // Re-run Prism highlighting
      if (window.Prism) {
        Prism.highlightAllUnder(tabContent);
      }
    });
  });
});
</script>
