<?php

use Flasher\Prime\Envelope;
use Flasher\Prime\Notification\Template;

if (!isset($envelope) || !$envelope instanceof Envelope) {
    return;
}

$notification = $envelope->getNotification();
if (!$notification instanceof Template) {
    return;
}

switch ($notification->getType()) {
    case 'success':
        $title = 'Success';
        $textColor = 'text-green-600';
        $backgroundColor = 'bg-green-600';
        $progressBackgroundColor = 'bg-green-100';
        $borderColor = 'border-green-600';
        $icon = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="check w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
        break;
    case 'error':
        $title = 'Error';
        $textColor = 'text-red-600';
        $backgroundColor = 'bg-red-600';
        $progressBackgroundColor = 'bg-red-100';
        $borderColor = 'border-red-600';
        $icon = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="x w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
        break;
    case 'warning':
        $title = 'Warning';
        $textColor = 'text-yellow-600';
        $backgroundColor = 'bg-yellow-600';
        $progressBackgroundColor = 'bg-yellow-100';
        $borderColor = 'border-yellow-600';
        $icon = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="exclamation w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
        break;
    case 'info':
    default:
        $title = 'Info';
        $textColor = 'text-blue-600';
        $backgroundColor = 'bg-blue-600';
        $progressBackgroundColor = 'bg-blue-100';
        $borderColor = 'border-blue-600';
        $icon = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="exclamation-circle w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
        break;
}
?>
<div class="bg-white shadow-lg border-l-4 mt-2 cursor-pointer {{ $borderColor }}">
    <div class="flex items-center px-2 py-3 rounded-lg shadow-lg overflow-hidden">
        <div class="inline-flex items-center {{ $backgroundColor }} p-2 text-white text-sm rounded-full flex-shrink-0">
            {!! $icon !!}
        </div>
        <div class="ml-4 w-0 flex-1">
            <p class="text-base leading-5 font-medium capitalize {{ $textColor }}">
                {{ $notification->getTitle() ?: $title }}
            </p>
            <p class="mt-1 text-sm leading-5 text-gray-500">
                {{ $notification->getMessage() }}
            </p>
        </div>
    </div>
    <div class="h-0.5 flex {{ $progressBackgroundColor }}">
        <span class="flasher-progress {{ $backgroundColor }}"></span>
    </div>
</div>
