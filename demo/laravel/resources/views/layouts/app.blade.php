<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PHPFlasher Demo') - Laravel</title>

    {{-- Tailwind CSS v4 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Prism.js for syntax highlighting --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.css">

    {{-- Prism.js code block fixes --}}
    <style>
        .code-block pre {
            margin: 0 !important;
            border-radius: 0 !important;
            background: #2d2d2d !important;
            padding: 1rem !important;
            overflow-x: auto;
        }
        .code-block code[class*="language-"] {
            font-size: 0.875rem;
            line-height: 1.6;
            background: transparent !important;
        }
    </style>

    {{-- Custom Tailwind components --}}
    <style type="text/tailwindcss">
        @layer components {
            .btn {
                @apply px-4 py-2 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 inline-flex items-center justify-center gap-2 cursor-pointer;
            }
            .btn-primary {
                @apply bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500/50;
            }
            .btn-success {
                @apply bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500/50;
            }
            .btn-danger {
                @apply bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-500/50;
            }
            .btn-warning {
                @apply bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-400/50;
            }
            .btn-info {
                @apply bg-sky-500 text-white hover:bg-sky-600 focus:ring-sky-400/50;
            }
            .btn-outline {
                @apply border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-indigo-500/50;
            }
            .btn-sm {
                @apply px-3 py-1.5 text-sm;
            }
            .card {
                @apply bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300;
            }
            .card-header {
                @apply px-6 py-4 border-b border-gray-100;
            }
            .card-body {
                @apply p-6;
            }
            .code-block {
                @apply rounded-lg overflow-hidden shadow-lg my-4;
            }
            .code-header {
                @apply bg-gray-800 text-gray-300 px-4 py-2 flex justify-between items-center text-sm font-mono;
            }
            .section-title {
                @apply text-2xl font-bold text-gray-800 mb-2;
            }
            .section-subtitle {
                @apply text-gray-600 mb-6;
            }
            .nav-link {
                @apply px-3 py-2 rounded-lg text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-colors font-medium;
            }
            .nav-link-active {
                @apply text-indigo-600 bg-indigo-50;
            }
        }
    </style>

    @stack('styles')

    {{-- Preload theme CSS for playground --}}
    <link rel="stylesheet" href="/vendor/flasher/flasher.min.css">
    <link rel="stylesheet" href="/vendor/flasher/themes/flasher/flasher.min.css">
    <link rel="stylesheet" href="/vendor/flasher/themes/material/material.min.css">
    <link rel="stylesheet" href="/vendor/flasher/themes/ios/ios.min.css">
    <link rel="stylesheet" href="/vendor/flasher/themes/slack/slack.min.css">
    <link rel="stylesheet" href="/vendor/flasher/themes/amazon/amazon.min.css">
    <link rel="stylesheet" href="/vendor/flasher/themes/google/google.min.css">

    {{-- Load main flasher script first, then themes --}}
    <script src="/vendor/flasher/flasher.min.js"></script>
    <script src="/vendor/flasher/themes/flasher/flasher.min.js"></script>
    <script src="/vendor/flasher/themes/material/material.min.js"></script>
    <script src="/vendor/flasher/themes/ios/ios.min.js"></script>
    <script src="/vendor/flasher/themes/slack/slack.min.js"></script>
    <script src="/vendor/flasher/themes/amazon/amazon.min.js"></script>
    <script src="/vendor/flasher/themes/google/google.min.js"></script>

    {{-- Render server-side notifications --}}
    @flasher_render
</head>
<body class="bg-gray-50 antialiased text-gray-900 min-h-screen flex flex-col">
    {{-- Header --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-xl font-bold text-gray-900">PHPFlasher</span>
                    <span class="hidden sm:inline-block px-2 py-0.5 text-xs font-medium bg-red-100 text-red-600 rounded-full">Laravel</span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="nav-link @if(request()->routeIs('home')) nav-link-active @endif">Home</a>
                    <a href="{{ route('types') }}" class="nav-link @if(request()->routeIs('types')) nav-link-active @endif">Types</a>
                    <a href="{{ route('themes') }}" class="nav-link @if(request()->routeIs('themes')) nav-link-active @endif">Themes</a>
                    <a href="{{ route('adapters') }}" class="nav-link @if(request()->routeIs('adapters')) nav-link-active @endif">Adapters</a>
                    <a href="{{ route('positions') }}" class="nav-link @if(request()->routeIs('positions')) nav-link-active @endif">Positions</a>
                    <a href="{{ route('examples') }}" class="nav-link @if(request()->routeIs('examples')) nav-link-active @endif">Examples</a>
                    <a href="{{ route('playground') }}" class="nav-link @if(request()->routeIs('playground')) nav-link-active @endif">Playground</a>
                    <a href="{{ route('livewire') }}" class="nav-link @if(request()->routeIs('livewire')) nav-link-active @endif">Livewire</a>
                </nav>

                {{-- External Links --}}
                <div class="hidden md:flex items-center space-x-3">
                    <a href="https://github.com/php-flasher/php-flasher" target="_blank" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="https://php-flasher.io" target="_blank" class="btn btn-primary btn-sm">
                        Documentation
                    </a>
                </div>

                {{-- Mobile menu button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('home')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Home</a>
                <a href="{{ route('types') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('types')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Types</a>
                <a href="{{ route('themes') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('themes')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Themes</a>
                <a href="{{ route('adapters') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('adapters')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Adapters</a>
                <a href="{{ route('positions') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('positions')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Positions</a>
                <a href="{{ route('examples') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('examples')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Examples</a>
                <a href="{{ route('playground') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('playground')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Playground</a>
                <a href="{{ route('livewire') }}" class="block px-3 py-2 rounded-lg @if(request()->routeIs('livewire')) bg-indigo-50 text-indigo-600 @else text-gray-600 hover:bg-gray-50 @endif">Livewire</a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>PHPFlasher Demo</span>
                </div>
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <a href="https://php-flasher.io" target="_blank" class="hover:text-indigo-600">Documentation</a>
                    <a href="https://github.com/php-flasher/php-flasher" target="_blank" class="hover:text-indigo-600">GitHub</a>
                    <span>Made with ❤️ by <a href="https://github.com/yoeunes" target="_blank" class="hover:text-indigo-600">Younes</a></span>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });

        // CSRF token for AJAX requests
        window.csrfToken = '{{ csrf_token() }}';

        // Helper function for notifications using PHPFlasher's JavaScript API
        window.showNotification = function(options) {
            const type = options.type || 'success';
            const message = options.message || 'Notification message';
            const title = options.title || null;
            const position = options.position || 'top-right';
            const timeout = options.timeout || 5000;

            // Use the theme if specified
            let plugin = 'flasher';
            if (options.theme && options.theme !== 'flasher') {
                plugin = 'theme.' + options.theme;
            }

            // Build notification options
            const notificationOptions = {
                position: position,
                timeout: timeout,
            };

            // Call PHPFlasher's JavaScript API
            flasher.use(plugin).flash(type, message, title, notificationOptions);
        };

        // Helper function for running examples using client-side notifications
        window.runExample = function(scenario) {
            const examples = {
                registration: [
                    { type: 'success', message: 'Welcome! Your account has been created.' },
                    { type: 'info', message: 'Please check your email to verify your account.' }
                ],
                login_failed: [
                    { type: 'error', message: 'Invalid email or password.' },
                    { type: 'info', message: 'Forgot your password? Click here to reset.' }
                ],
                validation: [
                    { type: 'error', message: 'The email field is required.' },
                    { type: 'error', message: 'Password must be at least 8 characters.' },
                    { type: 'error', message: 'Please accept the terms and conditions.' }
                ],
                shopping_cart: [
                    { type: 'success', message: 'iPhone 15 Pro added to cart!' },
                    { type: 'warning', message: 'Only 2 items left in stock!' },
                    { type: 'info', message: 'Add $20 more for free shipping!' }
                ],
                file_upload: [
                    { type: 'success', message: 'document.pdf uploaded successfully!' },
                    { type: 'info', message: 'File size: 2.4 MB' }
                ],
                settings: [
                    { type: 'success', message: 'Settings saved successfully!' },
                    { type: 'info', message: 'Some changes may require a page refresh.' }
                ],
                payment_success: [
                    { type: 'success', message: 'Payment of $149.99 confirmed!' },
                    { type: 'info', message: 'Order #12345 - Receipt sent to your email.' }
                ],
                payment_failed: [
                    { type: 'error', message: 'Payment declined by your bank.' },
                    { type: 'warning', message: 'Please try a different payment method.' },
                    { type: 'info', message: 'Your cart has been saved.' }
                ],
                delete_confirm: [
                    { type: 'warning', message: 'Are you sure? This action cannot be undone.' },
                    { type: 'info', message: 'Click confirm to delete or cancel to keep the item.' }
                ],
                session_expiring: [
                    { type: 'warning', message: 'Your session will expire in 5 minutes.' },
                    { type: 'info', message: 'Click anywhere to stay logged in.' }
                ]
            };

            const notifications = examples[scenario] || [{ type: 'info', message: 'Example not found' }];
            notifications.forEach((notification, index) => {
                setTimeout(() => {
                    flasher.flash(notification.type, notification.message);
                }, index * 300);
            });
        };
    </script>

    @stack('scripts')
</body>
</html>
