@extends('layouts.app')

@section('title', 'Home')

@section('content')
{{-- Hero Section --}}
<div class="text-center mb-12">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
        Beautiful Flash Notifications
    </h1>
    <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
        PHPFlasher makes it easy to add elegant notifications to your Laravel application.
        Try the quick demos below!
    </p>

    {{-- Quick Demo Buttons --}}
    <div class="flex flex-wrap justify-center gap-3 mb-8">
        <button onclick="showNotification({type: 'success', message: 'Operation completed successfully!', title: 'Success'})"
                class="btn btn-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Success
        </button>
        <button onclick="showNotification({type: 'error', message: 'Something went wrong. Please try again.', title: 'Error'})"
                class="btn btn-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Error
        </button>
        <button onclick="showNotification({type: 'warning', message: 'Please review your input before continuing.', title: 'Warning'})"
                class="btn btn-warning">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            Warning
        </button>
        <button onclick="showNotification({type: 'info', message: 'Here is some useful information for you.', title: 'Info'})"
                class="btn btn-info">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Info
        </button>
    </div>
</div>

{{-- Features Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    {{-- Feature 1: Types --}}
    <a href="{{ route('types') }}" class="card group">
        <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-emerald-100 rounded-lg group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Notification Types</h3>
            </div>
            <p class="text-gray-600">Success, error, warning, and info notifications for every use case.</p>
        </div>
    </a>

    {{-- Feature 2: Themes --}}
    <a href="{{ route('themes') }}" class="card group">
        <div class="h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">17+ Themes</h3>
            </div>
            <p class="text-gray-600">Material, iOS, Slack, Amazon, and many more beautiful themes.</p>
        </div>
    </a>

    {{-- Feature 3: Adapters --}}
    <a href="{{ route('adapters') }}" class="card group">
        <div class="h-2 bg-gradient-to-r from-blue-500 to-cyan-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Multiple Adapters</h3>
            </div>
            <p class="text-gray-600">Toastr, SweetAlert, Noty, and Notyf adapters included.</p>
        </div>
    </a>

    {{-- Feature 4: Positions --}}
    <a href="{{ route('positions') }}" class="card group">
        <div class="h-2 bg-gradient-to-r from-amber-500 to-orange-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-amber-100 rounded-lg group-hover:bg-amber-200 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Flexible Positions</h3>
            </div>
            <p class="text-gray-600">Place notifications anywhere on the screen.</p>
        </div>
    </a>

    {{-- Feature 5: Examples --}}
    <a href="{{ route('examples') }}" class="card group">
        <div class="h-2 bg-gradient-to-r from-rose-500 to-red-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-rose-100 rounded-lg group-hover:bg-rose-200 transition-colors">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Real Examples</h3>
            </div>
            <p class="text-gray-600">User registration, shopping cart, payments, and more.</p>
        </div>
    </a>

    {{-- Feature 6: Playground --}}
    <a href="{{ route('playground') }}" class="card group">
        <div class="h-2 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-3">
                <div class="p-2 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Interactive Playground</h3>
            </div>
            <p class="text-gray-600">Build and customize notifications in real-time.</p>
        </div>
    </a>
</div>

{{-- Quick Start Code --}}
<div class="card mb-12">
    <div class="card-header">
        <h2 class="text-xl font-bold text-gray-800">Quick Start</h2>
    </div>
    <div class="card-body">
        <p class="text-gray-600 mb-4">Get started with PHPFlasher in seconds. Just install and use!</p>

        <div class="code-block">
            <div class="code-header">
                <span>Installation</span>
            </div>
            <pre class="!m-0"><code class="language-bash">composer require php-flasher/flasher-laravel</code></pre>
        </div>

        <div class="code-block">
            <div class="code-header">
                <span>Usage</span>
            </div>
            <pre class="!m-0"><code class="language-php">// In your controller
flash()->success('Profile updated successfully!');

// With options
flash()->success('Welcome back!', [
    'position' => 'top-right',
    'timeout' => 5000,
]);

// Using themes
flash()->use('theme.material')->info('New feature available!');</code></pre>
        </div>
    </div>
</div>

{{-- CTA Section --}}
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-center text-white">
    <h2 class="text-2xl md:text-3xl font-bold mb-4">Ready to try PHPFlasher?</h2>
    <p class="text-indigo-100 mb-6 max-w-xl mx-auto">
        Explore the interactive playground to customize notifications and see the generated code.
    </p>
    <a href="{{ route('playground') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Open Playground
    </a>
</div>
@endsection
