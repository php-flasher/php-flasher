---
permalink: /
description: PHPFlasher is a powerful PHP notification library that makes it simple to add beautiful flash messages to your Laravel or Symfony applications. Perfect for form submissions, API responses, and user interactions.
data-controller: flasher
layout: home
---

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-indigo-50 to-white pt-16 pb-12 rounded-3xl mb-16 shadow-sm">
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute left-0 top-0 w-1/3 h-1/3 bg-gradient-to-br from-purple-100 to-transparent opacity-60 blur-3xl"></div>
    <div class="absolute right-0 bottom-0 w-1/3 h-1/3 bg-gradient-to-tl from-indigo-100 to-transparent opacity-60 blur-3xl"></div>
  </div>

  <div class="relative z-10 container mx-auto px-4">
    <div class="text-center">
      <div class="flex justify-center mb-4 animate-fade-in">
        <div class="relative">
          <span class="text-4xl md:text-5xl font-semibold text-indigo-900 italic transform -rotate-2 inline-block">PHP<span class="text-indigo-500">Flasher</span>
            <div class="absolute -right-3 -bottom-1 w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center animate-pulse">
              <div class="text-white text-xs">
                <i class="fa-solid fa-bolt"></i>
              </div>
            </div>
          </span>
        </div>
      </div>
      
      <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4 tracking-tight">
        Beautiful Flash Notifications <span class="text-indigo-600">Made Simple</span>
      </h1>
      
      <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
        Add elegant notifications to your Laravel or Symfony applications with just <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded">one line of code</span>. Perfect for developers of all skill levels.
      </p>
      
      <div class="flex flex-wrap gap-3 justify-center mb-8">
        <a href="#quick-start" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg flex items-center">
          <i class="fa-solid fa-rocket mr-2"></i> Get Started
        </a>
        <a href="https://github.com/php-flasher/php-flasher" class="px-5 py-3 bg-white hover:bg-slate-50 text-slate-700 font-medium rounded-lg border border-slate-200 transition-colors duration-200 flex items-center">
          <i class="fa-brands fa-github mr-2"></i> View on GitHub
        </a>
      </div>
      
      <div class="flex flex-wrap justify-center gap-3">
        <a href="https://www.linkedin.com/in/younes--ennaji/" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/badge/author-@yoeunes-blue.svg" alt="Author Badge" class="transform hover:scale-105 transition-transform" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/badge/source-php--flasher/php--flasher-blue.svg" alt="Source Code Badge" class="transform hover:scale-105 transition-transform" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher/releases" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/github/tag/php-flasher/flasher.svg" alt="GitHub Release Badge" class="transform hover:scale-105 transition-transform" />
        </a>
        <a href="https://github.com/php-flasher/flasher/blob/master/LICENSE" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="License Badge" class="transform hover:scale-105 transition-transform" />
        </a>
        <a href="https://packagist.org/packages/php-flasher/flasher" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/packagist/dt/php-flasher/flasher.svg" alt="Packagist Downloads Badge" class="transform hover:scale-105 transition-transform" />
        </a>
        <a href="https://github.com/php-flasher/php-flasher" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/github/stars/php-flasher/php-flasher.svg" alt="GitHub Stars Badge" class="transform hover:scale-105 transition-transform" />
        </a>
        <a href="https://packagist.org/packages/php-flasher/flasher" class="text-slate-500 hover:text-indigo-700 transition-colors duration-200">
          <img src="https://img.shields.io/packagist/php-v/php-flasher/flasher.svg" alt="Supported PHP Version Badge" class="transform hover:scale-105 transition-transform" />
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Interactive Demo Section -->
<section class="container mx-auto px-4 mb-16">
  <div class="text-center mb-8">
    <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium mb-2">Try It Now</div>
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">See the Magic in Action</h2>
    <p class="text-slate-600">Click to preview different notification types</p>
  </div>

  <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 max-w-4xl mx-auto">
    <div class="flex flex-wrap bg-slate-50 border-b border-slate-100 p-1 justify-between items-center">
      <div class="px-3 py-2 bg-white rounded-md shadow-sm mx-1 my-1 text-sm">index.php</div>
      <div class="flex flex-wrap gap-2 px-2">
        <button onclick="flasher.success('Your profile has been updated!', 'Success')" 
                class="px-3 py-1 bg-white hover:bg-gray-50 text-sm text-green-700 rounded-full border border-green-200 transition-colors flex items-center">
          <i class="fa-solid fa-circle-check mr-1.5 text-green-500"></i> Success
        </button>
        <button onclick="flasher.error('Oops! Something went wrong.', 'Error')"
                class="px-3 py-1 bg-white hover:bg-gray-50 text-sm text-red-700 rounded-full border border-red-200 transition-colors flex items-center">
          <i class="fa-solid fa-circle-xmark mr-1.5 text-red-500"></i> Error
        </button>
        <button onclick="flasher.info('Remember to verify your email.')"
                class="px-3 py-1 bg-white hover:bg-gray-50 text-sm text-blue-700 rounded-full border border-blue-200 transition-colors flex items-center">
          <i class="fa-solid fa-circle-info mr-1.5 text-blue-500"></i> Info
        </button>
        <button onclick="flasher.warning('Your subscription will expire soon.')"
                class="px-3 py-1 bg-white hover:bg-gray-50 text-sm text-amber-700 rounded-full border border-amber-200 transition-colors flex items-center">
          <i class="fa-solid fa-triangle-exclamation mr-1.5 text-amber-500"></i> Warning
        </button>
      </div>
    </div>
    
    <div class="p-6">
      <pre class="bg-slate-50 p-4 rounded-lg text-sm overflow-x-auto"><code class="language-php">// Show beautiful notifications with a single line
flash()->success('Your profile has been updated!');

// Display error messages
flash()->error('Oops! Something went wrong.');

// Info notifications
flash()->info('Remember to verify your email.');

// Warning alerts
flash()->warning('Your subscription will expire soon.');
</code></pre>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="container mx-auto px-4 mb-16">
  <div class="text-center mb-12">
    <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium mb-2">Features</div>
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">Why Choose PHPFlasher?</h2>
    <p class="text-slate-600 max-w-2xl mx-auto">Everything you need to add beautiful notifications to your PHP applications</p>
  </div>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
    <!-- Feature 1 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 p-6 flex flex-col h-full">
      <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center mb-4">
        <i class="fa-solid fa-wand-magic-sparkles text-indigo-600 text-xl"></i>
      </div>
      <h3 class="text-lg font-semibold text-slate-800 mb-2" id="easy-to-use">Easy to Use</h3>
      <ul class="space-y-2 text-slate-600 flex-grow">
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>Simple one-line code to show notifications</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>Works right out of the box</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>No complex configuration needed</span>
        </li>
      </ul>
    </div>
    
    <!-- Feature 2 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 p-6 flex flex-col h-full">
      <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-4">
        <i class="fa-solid fa-sliders text-purple-600 text-xl"></i>
      </div>
      <h3 class="text-lg font-semibold text-slate-800 mb-2" id="flexible">Flexible & Powerful</h3>
      <ul class="space-y-2 text-slate-600 flex-grow">
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span><a href="/library/toastr/" class="text-indigo-600 hover:underline">Toastr.js</a> - Classic toast notifications</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span><a href="/library/sweetalert/" class="text-indigo-600 hover:underline">SweetAlert 2</a> - Beautiful alert dialogs</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span><a href="/library/noty/" class="text-indigo-600 hover:underline">Noty</a> - Highly customizable notifications</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span><a href="/library/notyf/" class="text-indigo-600 hover:underline">Notyf</a> - Minimalist toast notifications</span>
        </li>
      </ul>
    </div>
    
    <!-- Feature 3 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 p-6 flex flex-col h-full">
      <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
        <i class="fa-solid fa-code text-blue-600 text-xl"></i>
      </div>
      <h3 class="text-lg font-semibold text-slate-800 mb-2" id="integration">Framework Integration</h3>
      <ul class="space-y-2 text-slate-600 flex-grow">
        <li class="flex items-start">
          <i class="fa-brands fa-laravel text-red-500 mt-1 mr-2"></i>
          <span>Native Laravel integration</span>
        </li>
        <li class="flex items-start">
          <i class="fa-brands fa-symfony text-black mt-1 mr-2"></i>
          <span>Seamless Symfony support</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-plug text-slate-600 mt-1 mr-2"></i>
          <span>Works with Livewire and Inertia</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-wrench text-slate-600 mt-1 mr-2"></i>
          <span>Framework-agnostic core</span>
        </li>
      </ul>
    </div>
    
    <!-- Feature 4 -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-100 p-6 flex flex-col h-full">
      <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center mb-4">
        <i class="fa-solid fa-user-gear text-emerald-600 text-xl"></i>
      </div>
      <h3 class="text-lg font-semibold text-slate-800 mb-2" id="developer-friendly">Developer Experience</h3>
      <ul class="space-y-2 text-slate-600 flex-grow">
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>Full IDE support with autocompletion</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>Clear documentation with examples</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>TypeScript support</span>
        </li>
        <li class="flex items-start">
          <i class="fa-solid fa-check text-green-500 mt-1 mr-2"></i>
          <span>Easy to customize and extend</span>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- Quick Start Section -->
<section id="quick-start" class="container mx-auto px-4 mb-16">
  <div class="text-center mb-12">
    <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium mb-2">Get Started</div>
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">Quick Installation</h2>
    <p class="text-slate-600 max-w-2xl mx-auto">Get up and running in less than a minute</p>
  </div>
  
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100 mb-8">
      <div class="bg-slate-800 p-4 flex items-center justify-between">
        <div class="flex items-center">
          <div class="flex space-x-1 mr-4">
            <div class="w-3 h-3 rounded-full bg-red-400"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
            <div class="w-3 h-3 rounded-full bg-green-400"></div>
          </div>
          <span class="text-slate-400 text-sm">Terminal</span>
        </div>
        <div class="text-slate-400 text-sm">Installation</div>
      </div>
      
      <div class="p-6 bg-slate-900">
        <div class="flex flex-col gap-4">
          <div class="relative">
            <div class="flex items-center mb-2">
              <div class="w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center mr-2 text-xs">
                <i class="fa-brands fa-laravel"></i>
              </div>
              <span class="text-slate-300 text-sm">Laravel Installation</span>
            </div>
            <pre class="bg-slate-800 p-4 rounded-lg text-sm overflow-x-auto"><code class="language-bash text-slate-200">composer require php-flasher/flasher-laravel</code></pre>
            <button class="absolute top-12 right-3 text-slate-400 hover:text-slate-200 transition-colors" 
                    onclick="navigator.clipboard.writeText('composer require php-flasher/flasher-laravel')">
              <i class="fa-regular fa-copy"></i>
            </button>
          </div>
          
          <div class="relative">
            <div class="flex items-center mb-2">
              <div class="w-5 h-5 bg-black text-white rounded-full flex items-center justify-center mr-2 text-xs">
                <i class="fa-brands fa-symfony"></i>
              </div>
              <span class="text-slate-300 text-sm">Symfony Installation</span>
            </div>
            <pre class="bg-slate-800 p-4 rounded-lg text-sm overflow-x-auto"><code class="language-bash text-slate-200">composer require php-flasher/flasher-symfony</code></pre>
            <button class="absolute top-12 right-3 text-slate-400 hover:text-slate-200 transition-colors"
                    onclick="navigator.clipboard.writeText('composer require php-flasher/flasher-symfony')">
              <i class="fa-regular fa-copy"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Laravel Quick Start -->
      <a href="/laravel/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden hover:border-red-200">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-100 transition-colors">
              <i class="fa-brands fa-laravel text-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-800">Laravel Guide</h3>
          </div>
          <p class="text-slate-600 mb-4">Perfect integration with Laravel's notification system. Get started in minutes.</p>
          <div class="flex items-center text-red-600 font-medium">
            Learn more
            <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>
      
      <!-- Symfony Quick Start -->
      <a href="/symfony/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden hover:border-slate-300">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-slate-50 text-black rounded-lg flex items-center justify-center mr-3 group-hover:bg-slate-100 transition-colors">
              <i class="fa-brands fa-symfony text-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-800">Symfony Guide</h3>
          </div>
          <p class="text-slate-600 mb-4">Complete Symfony integration with bundle configuration and services.</p>
          <div class="flex items-center text-slate-700 font-medium">
            Learn more
            <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <!-- Livewire Quick Start -->
      <a href="/livewire/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden hover:border-purple-200">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-100 transition-colors">
              <i class="fa-solid fa-bolt text-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-800">Livewire Guide</h3>
          </div>
          <p class="text-slate-600 mb-4">Real-time notifications in your Laravel Livewire components.</p>
          <div class="flex items-center text-purple-600 font-medium">
            Learn more
            <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>
      
      <!-- Inertia Quick Start -->
      <a href="/inertia/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden hover:border-blue-200">
        <div class="p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-100 transition-colors">
              <i class="fa-solid fa-arrows-rotate text-lg"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-800">Inertia Guide</h3>
          </div>
          <p class="text-slate-600 mb-4">Modern SPA notifications with Inertia.js integration.</p>
          <div class="flex items-center text-blue-600 font-medium">
            Learn more
            <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- Library Showcase Section -->
<section class="container mx-auto px-4 mb-16">
  <div class="text-center mb-12">
    <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium mb-2">Libraries</div>
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">Choose Your Preferred Library</h2>
    <p class="text-slate-600 max-w-2xl mx-auto">PHPFlasher integrates with popular JavaScript notification libraries</p>
  </div>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
    <!-- Toastr -->
    <a href="/library/toastr/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
      <div class="h-32 bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
          <i class="fa-solid fa-toast text-blue-500 text-2xl"></i>
        </div>
      </div>
      <div class="p-5 flex-grow">
        <h3 class="font-semibold text-slate-800 mb-2">Toastr.js</h3>
        <p class="text-slate-600 text-sm mb-3">Simple toast notifications for web applications. Clean, elegant and customizable.</p>
        <div class="flex items-center text-blue-600 font-medium text-sm group-hover:underline">
          Learn more <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
        </div>
      </div>
    </a>
    
    <!-- SweetAlert2 -->
    <a href="/library/sweetalert/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
      <div class="h-32 bg-gradient-to-r from-pink-400 to-red-500 flex items-center justify-center">
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
          <i class="fa-solid fa-message-exclamation text-pink-500 text-2xl"></i>
        </div>
      </div>
      <div class="p-5 flex-grow">
        <h3 class="font-semibold text-slate-800 mb-2">SweetAlert2</h3>
        <p class="text-slate-600 text-sm mb-3">Beautiful, responsive, customizable alert dialogs with interactive elements.</p>
        <div class="flex items-center text-pink-600 font-medium text-sm group-hover:underline">
          Learn more <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
        </div>
      </div>
    </a>
    
    <!-- Noty -->
    <a href="/library/noty/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
      <div class="h-32 bg-gradient-to-r from-purple-400 to-indigo-500 flex items-center justify-center">
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
          <i class="fa-solid fa-bell text-purple-500 text-2xl"></i>
        </div>
      </div>
      <div class="p-5 flex-grow">
        <h3 class="font-semibold text-slate-800 mb-2">Noty</h3>
        <p class="text-slate-600 text-sm mb-3">Highly customizable notification library with multiple positions and animations.</p>
        <div class="flex items-center text-purple-600 font-medium text-sm group-hover:underline">
          Learn more <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
        </div>
      </div>
    </a>
    
    <!-- Notyf -->
    <a href="/library/notyf/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
      <div class="h-32 bg-gradient-to-r from-green-400 to-teal-500 flex items-center justify-center">
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
          <i class="fa-solid fa-message-dots text-green-500 text-2xl"></i>
        </div>
      </div>
            <div class="p-5 flex-grow">
        <h3 class="font-semibold text-slate-800 mb-2">Notyf</h3>
        <p class="text-slate-600 text-sm mb-3">Minimalist toast notifications with a clean design and smooth animations.</p>
        <div class="flex items-center text-green-600 font-medium text-sm group-hover:underline">
          Learn more <i class="fa-solid fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform"></i>
        </div>
      </div>
    </a>
  </div>
</section>

<!-- Code Example Section -->
<section class="container mx-auto px-4 mb-16">
  <div class="text-center mb-12">
    <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium mb-2">Code Examples</div>
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">Simple Implementation</h2>
    <p class="text-slate-600 max-w-2xl mx-auto">Just a few lines of code to get started</p>
  </div>
  
  <div class="flex flex-col gap-8 max-w-4xl mx-auto">
    <!-- PHP Example -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100">
      <div class="bg-slate-800 px-4 py-3 flex items-center">
        <div class="flex space-x-1.5 mr-3">
          <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
          <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
          <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
        </div>
        <div class="text-white opacity-80 text-xs font-medium">Controller.php</div>
      </div>
      <div class="p-5">
        <pre class="bg-slate-50 rounded-lg p-4 text-sm overflow-x-auto"><code class="language-php">namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // Update user profile logic
        
        // Show success notification
        flash()->success('Profile updated successfully!');
        
        // Or add a title
        flash()->success('Your changes have been saved.', 'Profile Updated');
        
        // Change notification options
        flash()->options([
            'timeout' => 5000,
            'position' => 'top-right'
        ])->success('Changes saved with custom settings');
        
        return back();
    }
}</code></pre>
      </div>
    </div>
    
    <!-- JavaScript Example -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-slate-100">
      <div class="bg-slate-800 px-4 py-3 flex items-center">
        <div class="flex space-x-1.5 mr-3">
          <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
          <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
          <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
        </div>
        <div class="text-white opacity-80 text-xs font-medium">app.js</div>
      </div>
      <div class="p-5">
        <pre class="bg-slate-50 rounded-lg p-4 text-sm overflow-x-auto"><code class="language-javascript">// Form submission example
document.getElementById('contact-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const response = await submitForm(this);
        
        if (response.success) {
            // Show success notification
            flasher.success('Your message has been sent!', 'Thank You');
        } else {
            // Show error notification
            flasher.error('Please check your form inputs', 'Error');
        }
    } catch (error) {
        // Show error notification with details
        flasher.error('Server error, please try again later.', 'Error');
        console.error(error);
    }
});</code></pre>
      </div>
    </div>
  </div>
</section>

<!-- Community Section -->
<section class="bg-gradient-to-b from-slate-50 to-white py-16 mb-16">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <div class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium mb-2">Community</div>
      <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">Join Our Growing Community</h2>
      <p class="text-slate-600 max-w-2xl mx-auto">Help us make PHPFlasher even better</p>
    </div>
    
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- GitHub -->
      <a href="https://github.com/php-flasher/php-flasher" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 p-6 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 group-hover:bg-slate-100 transition-colors">
          <i class="fa-brands fa-github text-slate-800 text-3xl"></i>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Star on GitHub</h3>
        <p class="text-slate-600 text-sm">Contribute to the project, report issues, or suggest new features.</p>
        <div class="mt-4 px-4 py-2 bg-slate-100 rounded-full text-slate-700 text-sm font-medium group-hover:bg-slate-200 transition-colors">
          <i class="fa-regular fa-star mr-1"></i> Star
        </div>
      </a>
      
      <!-- Discussions -->
      <a href="https://github.com/php-flasher/php-flasher/discussions" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 p-6 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mb-4 group-hover:bg-indigo-100 transition-colors">
          <i class="fa-solid fa-comments text-indigo-600 text-3xl"></i>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Join Discussions</h3>
        <p class="text-slate-600 text-sm">Ask questions, share ideas, and connect with other users.</p>
        <div class="mt-4 px-4 py-2 bg-indigo-100 rounded-full text-indigo-700 text-sm font-medium group-hover:bg-indigo-200 transition-colors">
          <i class="fa-regular fa-message mr-1"></i> Participate
        </div>
      </a>
      
      <!-- Documentation -->
      <a href="/docs/" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 p-6 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mb-4 group-hover:bg-amber-100 transition-colors">
          <i class="fa-solid fa-book-open text-amber-600 text-3xl"></i>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Read Documentation</h3>
        <p class="text-slate-600 text-sm">Explore comprehensive guides, examples, and API reference.</p>
        <div class="mt-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 text-sm font-medium group-hover:bg-amber-200 transition-colors">
          <i class="fa-solid fa-arrow-right mr-1"></i> Get Started
        </div>
      </a>
    </div>
  </div>
</section>

<!-- Call To Action -->
<section class="container mx-auto px-4 mb-16">
  <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl overflow-hidden shadow-lg">
    <div class="max-w-4xl mx-auto px-6 py-16 text-center">
      <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Enhance Your PHP Applications?</h2>
      <p class="text-indigo-100 text-lg mb-8 max-w-2xl mx-auto">
        Add beautiful notifications to your Laravel or Symfony applications in minutes with PHPFlasher.
      </p>
      <div class="flex flex-wrap justify-center gap-4">
        <a href="#quick-start" class="px-6 py-3 bg-white hover:bg-slate-100 text-indigo-600 font-medium rounded-lg transition-colors duration-200 shadow-md flex items-center">
          <i class="fa-solid fa-rocket mr-2"></i> Get Started
        </a>
        <a href="https://github.com/php-flasher/php-flasher" class="px-6 py-3 bg-indigo-700 hover:bg-indigo-800 text-white font-medium rounded-lg transition-colors duration-200 shadow-md flex items-center">
          <i class="fa-brands fa-github mr-2"></i> Star on GitHub
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Browser Support Section -->
<section class="container mx-auto px-4 mb-16">
  <div class="text-center mb-8">
    <div class="inline-block px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-sm font-medium mb-2">Support</div>
    <h2 class="text-xl font-bold text-slate-800">Compatible Everywhere</h2>
  </div>
  
  <div class="bg-white rounded-xl shadow-sm border border-slate-100 py-8">
    <div class="flex flex-wrap justify-center gap-10 px-4">
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-2">
          <i class="fa-brands fa-chrome text-green-500 text-2xl"></i>
        </div>
        <span class="text-sm text-slate-600">Chrome</span>
      </div>
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-2">
          <i class="fa-brands fa-firefox text-orange-500 text-2xl"></i>
        </div>
        <span class="text-sm text-slate-600">Firefox</span>
      </div>
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-2">
          <i class="fa-brands fa-safari text-blue-500 text-2xl"></i>
        </div>
        <span class="text-sm text-slate-600">Safari</span>
      </div>
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-2">
          <i class="fa-brands fa-edge text-blue-600 text-2xl"></i>
        </div>
        <span class="text-sm text-slate-600">Edge</span>
      </div>
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-2">
          <i class="fa-solid fa-mobile-screen text-slate-600 text-2xl"></i>
        </div>
        <span class="text-sm text-slate-600">Mobile</span>
      </div>
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-2">
          <i class="fa-solid fa-moon text-indigo-500 text-2xl"></i>
        </div>
        <span class="text-sm text-slate-600">Dark Mode</span>
      </div>
    </div>
  </div>
</section>

<!-- Add animation utility classes -->
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.6s ease-out forwards;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.6; }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<!-- Copy to clipboard functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const copyButtons = document.querySelectorAll('[onclick^="navigator.clipboard.writeText"]');
  
  copyButtons.forEach(button => {
    button.addEventListener('click', function() {
      const originalIcon = this.innerHTML;
      this.innerHTML = '<i class="fa-solid fa-check"></i>';
      
      setTimeout(() => {
        this.innerHTML = originalIcon;
      }, 2000);
    });
  });
});
</script>
