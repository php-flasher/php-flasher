@extends('layouts.app')

@section('title', 'Real-World Examples')

@section('content')
<div class="mb-8">
    <h1 class="section-title">Real-World Examples</h1>
    <p class="section-subtitle">See how PHPFlasher handles common application scenarios. Click to run each example.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- User Registration --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-emerald-500 to-green-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">User Registration</h3>
                    <p class="text-sm text-gray-500">Account creation flow</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Simulates a successful user registration with welcome message and email verification notice.</p>

            <button onclick="runExample('registration')" class="btn btn-success w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->success('Welcome! Your account has been created.');
flash()->info('Please check your email to verify your account.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Login Flow --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-rose-500 to-red-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-rose-100 rounded-xl">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Login Failed</h3>
                    <p class="text-sm text-gray-500">Authentication error</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Shows how to display login failure messages with helpful guidance.</p>

            <button onclick="runExample('login_failed')" class="btn btn-danger w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->error('Invalid email or password.');
flash()->info('Forgot your password? Click here to reset.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Form Validation --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-amber-500 to-yellow-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-amber-100 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Form Validation</h3>
                    <p class="text-sm text-gray-500">Multiple field errors</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Demonstrates displaying multiple validation errors from a form submission.</p>

            <button onclick="runExample('validation')" class="btn btn-warning w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->error('The email field is required.');
flash()->error('Password must be at least 8 characters.');
flash()->error('Please accept the terms and conditions.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Shopping Cart --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Shopping Cart</h3>
                    <p class="text-sm text-gray-500">E-commerce interactions</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Shows notifications for adding items to cart with stock warnings and promotions.</p>

            <button onclick="runExample('shopping_cart')" class="btn btn-primary w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->success('iPhone 15 Pro added to cart!');
flash()->warning('Only 2 items left in stock!');
flash()->info('Add $20 more for free shipping!');</code></pre>
            </div>
        </div>
    </div>

    {{-- File Upload --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-sky-500 to-cyan-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-sky-100 rounded-xl">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">File Upload</h3>
                    <p class="text-sm text-gray-500">Upload progress and status</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Demonstrates file upload progress with success and additional info.</p>

            <button onclick="runExample('file_upload')" class="btn btn-info w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->success('document.pdf uploaded successfully!');
flash()->info('File size: 2.4 MB');</code></pre>
            </div>
        </div>
    </div>

    {{-- Settings Saved --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-teal-500 to-green-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-teal-100 rounded-xl">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Settings Saved</h3>
                    <p class="text-sm text-gray-500">Preferences updated</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Shows settings save confirmation with additional context.</p>

            <button onclick="runExample('settings')" class="btn btn-success w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->success('Settings saved successfully!');
flash()->info('Some changes may require a page refresh.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Payment Success --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-green-500 to-emerald-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Payment Success</h3>
                    <p class="text-sm text-gray-500">Transaction completed</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Payment confirmation with order details and receipt notification.</p>

            <button onclick="runExample('payment_success')" class="btn btn-success w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->success('Payment of $149.99 confirmed!');
flash()->info('Order #12345 - Receipt sent to your email.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Payment Failed --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-red-500 to-rose-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-red-100 rounded-xl">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Payment Failed</h3>
                    <p class="text-sm text-gray-500">Transaction declined</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Payment failure with helpful guidance for resolving the issue.</p>

            <button onclick="runExample('payment_failed')" class="btn btn-danger w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->error('Payment declined by your bank.');
flash()->warning('Please try a different payment method.');
flash()->info('Your cart has been saved.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-pink-500 to-rose-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-pink-100 rounded-xl">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Delete Confirmation</h3>
                    <p class="text-sm text-gray-500">SweetAlert dialog</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Uses SweetAlert for a confirmation dialog before deleting.</p>

            <button onclick="runExample('delete_confirm')" class="btn btn-danger w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">sweetalert()
    ->showCancelButton()
    ->confirmButtonText('Yes, delete it!')
    ->cancelButtonText('Cancel')
    ->warning('Are you sure? This cannot be undone.');</code></pre>
            </div>
        </div>
    </div>

    {{-- Session Expiring --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-orange-500 to-amber-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-orange-100 rounded-xl">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Session Expiring</h3>
                    <p class="text-sm text-gray-500">Timeout warning</p>
                </div>
            </div>

            <p class="text-gray-600 mb-4">Alerts user when their session is about to expire.</p>

            <button onclick="runExample('session_expiring')" class="btn btn-warning w-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                </svg>
                Run Example
            </button>

            <div class="code-block">
                <div class="code-header"><span>PHP</span></div>
                <pre class="!m-0"><code class="language-php">flash()->warning('Your session will expire in 5 minutes.');
flash()->info('Click anywhere to stay logged in.');</code></pre>
            </div>
        </div>
    </div>
</div>
@endsection
