@extends('layouts.app')

@section('title', 'Positions')

@section('content')
<div class="mb-8">
    <h1 class="section-title">Notification Positions</h1>
    <p class="section-subtitle">Place your notifications anywhere on the screen. Click any position to see it in action.</p>
</div>

{{-- Interactive Position Grid --}}
<div class="card mb-8">
    <div class="card-header">
        <h2 class="text-xl font-bold text-gray-800">Click a Position</h2>
    </div>
    <div class="card-body">
        <div class="bg-gray-100 rounded-xl p-4 relative" style="min-height: 400px;">
            {{-- Visual Browser Frame --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden h-full" style="min-height: 380px;">
                {{-- Browser Header --}}
                <div class="bg-gray-200 px-4 py-2 flex items-center space-x-2">
                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    <div class="flex-1 ml-4">
                        <div class="bg-white rounded px-3 py-1 text-sm text-gray-500 max-w-md">your-app.com</div>
                    </div>
                </div>

                {{-- Position Grid --}}
                <div class="grid grid-cols-3 grid-rows-3 gap-2 p-4" style="min-height: 340px;">
                    {{-- Top Left --}}
                    <button onclick="showNotification({type: 'info', message: 'Top Left notification', position: 'top-left'})"
                            class="flex items-start justify-start p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors group">
                        <div class="bg-indigo-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            top-left
                        </div>
                    </button>

                    {{-- Top Center --}}
                    <button onclick="showNotification({type: 'info', message: 'Top Center notification', position: 'top-center'})"
                            class="flex items-start justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                        <div class="bg-purple-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            top-center
                        </div>
                    </button>

                    {{-- Top Right --}}
                    <button onclick="showNotification({type: 'info', message: 'Top Right notification', position: 'top-right'})"
                            class="flex items-start justify-end p-4 bg-pink-50 hover:bg-pink-100 rounded-lg transition-colors group">
                        <div class="bg-pink-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            top-right
                        </div>
                    </button>

                    {{-- Center Left --}}
                    <button onclick="showNotification({type: 'info', message: 'Center Left notification', position: 'center-left'})"
                            class="flex items-center justify-start p-4 bg-sky-50 hover:bg-sky-100 rounded-lg transition-colors group">
                        <div class="bg-sky-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            center-left
                        </div>
                    </button>

                    {{-- Center --}}
                    <button onclick="showNotification({type: 'info', message: 'Center notification', position: 'center'})"
                            class="flex items-center justify-center p-4 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors group">
                        <div class="bg-amber-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            center
                        </div>
                    </button>

                    {{-- Center Right --}}
                    <button onclick="showNotification({type: 'info', message: 'Center Right notification', position: 'center-right'})"
                            class="flex items-center justify-end p-4 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors group">
                        <div class="bg-emerald-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            center-right
                        </div>
                    </button>

                    {{-- Bottom Left --}}
                    <button onclick="showNotification({type: 'info', message: 'Bottom Left notification', position: 'bottom-left'})"
                            class="flex items-end justify-start p-4 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors group">
                        <div class="bg-rose-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            bottom-left
                        </div>
                    </button>

                    {{-- Bottom Center --}}
                    <button onclick="showNotification({type: 'info', message: 'Bottom Center notification', position: 'bottom-center'})"
                            class="flex items-end justify-center p-4 bg-teal-50 hover:bg-teal-100 rounded-lg transition-colors group">
                        <div class="bg-teal-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            bottom-center
                        </div>
                    </button>

                    {{-- Bottom Right --}}
                    <button onclick="showNotification({type: 'info', message: 'Bottom Right notification', position: 'bottom-right'})"
                            class="flex items-end justify-end p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors group">
                        <div class="bg-orange-500 text-white px-3 py-2 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            bottom-right
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Buttons --}}
<div class="card mb-8">
    <div class="card-header">
        <h2 class="text-xl font-bold text-gray-800">Quick Position Tests</h2>
    </div>
    <div class="card-body">
        <div class="flex flex-wrap gap-3">
            <button onclick="showNotification({type: 'success', message: 'Top Right (Default)', position: 'top-right'})"
                    class="btn btn-success">Top Right</button>
            <button onclick="showNotification({type: 'error', message: 'Top Left notification', position: 'top-left'})"
                    class="btn btn-danger">Top Left</button>
            <button onclick="showNotification({type: 'warning', message: 'Bottom Right notification', position: 'bottom-right'})"
                    class="btn btn-warning">Bottom Right</button>
            <button onclick="showNotification({type: 'info', message: 'Bottom Left notification', position: 'bottom-left'})"
                    class="btn btn-info">Bottom Left</button>
            <button onclick="showNotification({type: 'success', message: 'Top Center notification', position: 'top-center'})"
                    class="btn btn-outline">Top Center</button>
            <button onclick="showNotification({type: 'info', message: 'Bottom Center notification', position: 'bottom-center'})"
                    class="btn btn-outline">Bottom Center</button>
        </div>
    </div>
</div>

{{-- Code Examples --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-bold text-gray-800">Inline Position</h3>
        </div>
        <div class="card-body">
            <p class="text-gray-600 mb-4">Set the position directly when creating a notification.</p>
            <div class="code-block">
                <div class="code-header">
                    <span>PHP</span>
                </div>
                <pre class="!m-0"><code class="language-php">flash()
    ->option('position', 'top-left')
    ->success('Profile updated!');

// Or use the fluent method
flash()
    ->position('bottom-right')
    ->info('New message received!');</code></pre>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-bold text-gray-800">Global Configuration</h3>
        </div>
        <div class="card-body">
            <p class="text-gray-600 mb-4">Set a default position for all notifications in your config file.</p>
            <div class="code-block">
                <div class="code-header">
                    <span>config/flasher.php</span>
                </div>
                <pre class="!m-0"><code class="language-php">return [
    'default' => 'flasher',
    'options' => [
        'position' => 'bottom-right',
    ],
];</code></pre>
            </div>
        </div>
    </div>
</div>

{{-- Position Reference --}}
<div class="card mt-6">
    <div class="card-header">
        <h2 class="text-xl font-bold text-gray-800">Available Positions</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-2">Top Positions</h4>
                <ul class="space-y-1 text-gray-600 text-sm">
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">top-left</code></li>
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">top-center</code></li>
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">top-right</code> <span class="text-emerald-600">(default)</span></li>
                </ul>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-2">Center Positions</h4>
                <ul class="space-y-1 text-gray-600 text-sm">
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">center-left</code></li>
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">center</code></li>
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">center-right</code></li>
                </ul>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <h4 class="font-semibold text-gray-800 mb-2">Bottom Positions</h4>
                <ul class="space-y-1 text-gray-600 text-sm">
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">bottom-left</code></li>
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">bottom-center</code></li>
                    <li><code class="bg-gray-200 px-2 py-0.5 rounded">bottom-right</code></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
