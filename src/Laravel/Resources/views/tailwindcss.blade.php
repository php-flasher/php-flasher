@php
    use Flasher\Prime\Notification\Envelope;

    /** @var Envelope $envelope */

    $type = $envelope->getType();
    $message = $envelope->getMessage();

    $config = match($type) {
        'success' => [
            'title' => 'Success',
            'text_color' => 'text-green-600',
            'ring_color' => 'ring-green-300',
            'background_color' => 'bg-green-600',
            'progress_background_color' => 'bg-green-100',
            'border_color' => 'border-green-600',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="check w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        ],
        'error' => [
            'title' => 'Error',
            'text_color' => 'text-red-600',
            'ring_color' => 'ring-red-300',
            'background_color' => 'bg-red-600',
            'progress_background_color' => 'bg-red-100',
            'border_color' => 'border-red-600',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="x w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
        ],
        'warning' => [
            'title' => 'Warning',
            'text_color' => 'text-yellow-600',
            'ring_color' => 'ring-yellow-300',
            'background_color' => 'bg-yellow-600',
            'progress_background_color' => 'bg-yellow-100',
            'border_color' => 'border-yellow-600',
            'icon' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="exclamation w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        ],
        default => [
            'title' => 'Info',
            'text_color' => 'text-blue-600',
            'ring_color' => 'ring-blue-300',
            'background_color' => 'bg-blue-600',
            'progress_background_color' => 'bg-blue-100',
            'border_color' => 'border-blue-600',
            'icon' => '<svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        ],
    };
@endphp

<div class="bg-white shadow-inner border-l-4 mt-2 cursor-pointer {{ $config['border_color'] }}">
    <div class="flex items-center px-2 py-3 rounded-lg shadow-lg overflow-hidden">
        <div class="inline-flex items-center {{ $config['background_color'] }} p-1 text-white text-sm rounded-full flex-shrink-0">
            {!! $config['icon'] !!}
        </div>
        <div class="ml-4 w-0 flex-1">
            <p class="text-base leading-5 font-medium capitalize {{ $config['text_color'] }}">
                {{ $config['title'] }}
            </p>
            <p class="mt-1 text-sm leading-5 text-gray-500">
                {{ $message }}
            </p>
        </div>
    </div>
    <div class="h-0.5 flex {{ $config['progress_background_color'] }}">
        <span class="flasher-progress {{ $config['background_color'] }}"></span>
    </div>
</div>
