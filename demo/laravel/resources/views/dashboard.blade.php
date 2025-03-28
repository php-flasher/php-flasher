@extends('layouts.app')

@section('title', 'PHPFlasher Laravel Demo')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <div class="uppercase tracking-wide text-sm text-indigo-600 font-semibold">Laravel Demo</div>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900">Welcome to PHPFlasher</h2>
            <p class="mt-4 text-lg text-gray-500">
                PHPFlasher is a powerful notification library for PHP applications.
                This demo shows how to use PHPFlasher in a Laravel project.
            </p>

            <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature Cards -->
                <div class="bg-indigo-50 p-6 rounded-lg">
                    <div class="text-indigo-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Easy Integration</h3>
                    <p class="text-gray-600">Simple API to create notifications from anywhere in your Laravel application.</p>
                </div>

                <div class="bg-emerald-50 p-6 rounded-lg">
                    <div class="text-emerald-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Multiple Themes</h3>
                    <p class="text-gray-600">Choose from 15+ beautiful themes or create your own custom themes.</p>
                </div>

                <div class="bg-amber-50 p-6 rounded-lg">
                    <div class="text-amber-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Flexible Positioning</h3>
                    <p class="text-gray-600">Display notifications at any corner or side of your screen.</p>
                </div>
            </div>

            <div class="mt-10">
                <h3 class="text-lg font-medium text-gray-900">Try It Now</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('all.types') }}" class="btn-primary">
                        Show All Notification Types
                    </a>
                    <a href="{{ route('themes') }}" class="btn-outline">
                        Explore Themes
                    </a>
                </div>
            </div>

            <div class="mt-10">
                <h3 class="text-lg font-medium text-gray-900">Code Example</h3>
                <div class="mt-4 code-block">
                    <div class="code-header">
                        <span>Basic Usage</span>
                    </div>
<pre><code class="language-php">// Display a success notification
flash()->success('Item created successfully!');

// Display an error notification
flash()->error('An error occurred!');

// Display a warning notification
flash()->warning('Warning: This action cannot be undone.');

// Display an info notification
flash()->info('The task is running in the background.');</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
