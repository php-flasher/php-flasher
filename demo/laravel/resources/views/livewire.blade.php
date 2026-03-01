@extends('layouts.app')

@section('title', 'Livewire Integration')

@section('content')
<div class="mb-8">
    <h1 class="section-title">Livewire Integration</h1>
    <p class="section-subtitle">PHPFlasher works seamlessly with Laravel Livewire. See live examples below.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Counter Component --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Counter Component</h3>
                    <p class="text-sm text-gray-500">Simple state management</p>
                </div>
            </div>

            @livewire('counter')

            <div class="code-block mt-6">
                <div class="code-header">
                    <span>app/Livewire/Counter.php</span>
                </div>
                <pre class="!m-0"><code class="language-php">class Counter extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
        flash()->success("Count increased to {$this->count}!");
    }

    public function decrement(): void
    {
        $this->count--;
        flash()->warning("Count decreased to {$this->count}");
    }

    public function reset(): void
    {
        $this->count = 0;
        flash()->info('Counter has been reset.');
    }
}</code></pre>
            </div>
        </div>
    </div>

    {{-- Contact Form Component --}}
    <div class="card">
        <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
        <div class="card-body">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Contact Form</h3>
                    <p class="text-sm text-gray-500">Form validation example</p>
                </div>
            </div>

            @livewire('contact-form')

            <div class="code-block mt-6">
                <div class="code-header">
                    <span>app/Livewire/ContactForm.php</span>
                </div>
                <pre class="!m-0"><code class="language-php">class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submit(): void
    {
        $this->validate();

        // Process form...

        flash()->success('Message sent successfully!');
        flash()->info('We will respond within 24 hours.');

        $this->reset(['name', 'email', 'message']);
    }
}</code></pre>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert Events --}}
<div class="card mt-8">
    <div class="h-2 bg-gradient-to-r from-pink-500 to-rose-500"></div>
    <div class="card-body">
        <div class="flex items-center space-x-3 mb-6">
            <div class="p-3 bg-pink-100 rounded-xl">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">SweetAlert Confirmations</h3>
                <p class="text-sm text-gray-500">Handle dialog responses in Livewire</p>
            </div>
        </div>

        @livewire('delete-item')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="code-block">
                <div class="code-header">
                    <span>Component</span>
                </div>
                <pre class="!m-0"><code class="language-php">class DeleteItem extends Component
{
    protected $listeners = [
        'sweetalert:confirmed' => 'onConfirmed',
        'sweetalert:denied' => 'onDenied',
    ];

    public function confirmDelete(): void
    {
        sweetalert()
            ->showDenyButton()
            ->showCancelButton()
            ->confirmButtonText('Yes, delete!')
            ->denyButtonText('Keep it')
            ->warning('Delete this item?');
    }

    public function onConfirmed(array $payload): void
    {
        // Delete the item...
        flash()->success('Item deleted!');
    }

    public function onDenied(array $payload): void
    {
        flash()->info('Item was kept.');
    }
}</code></pre>
            </div>

            <div class="code-block">
                <div class="code-header">
                    <span>Blade Template</span>
                </div>
                <pre class="!m-0"><code class="language-php">&lt;div&gt;
    &lt;button wire:click="confirmDelete"
            class="btn btn-danger"&gt;
        Delete Item
    &lt;/button&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>
    </div>
</div>

{{-- Installation Guide --}}
<div class="card mt-8">
    <div class="card-header">
        <h2 class="text-xl font-bold text-gray-800">Livewire Setup</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-800 mb-3">1. Install PHPFlasher</h3>
                <div class="code-block">
                    <div class="code-header"><span>Terminal</span></div>
                    <pre class="!m-0"><code class="language-bash">composer require php-flasher/flasher-laravel</code></pre>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-gray-800 mb-3">2. Use in Components</h3>
                <div class="code-block">
                    <div class="code-header"><span>PHP</span></div>
                    <pre class="!m-0"><code class="language-php">public function save()
{
    // Your logic...
    flash()->success('Saved!');
}</code></pre>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-semibold text-indigo-800">Automatic Livewire Support</h4>
                    <p class="text-indigo-700 text-sm mt-1">PHPFlasher automatically detects Livewire requests and handles them appropriately. No additional configuration needed!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
