<?php

declare(strict_types=1);

namespace Flasher\Laravel\EventListener;

use Flasher\Laravel\Storage\FallbackSession;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Laravel\Octane\Events\RequestReceived;

final readonly class OctaneListener
{
    public function __invoke(RequestReceived $event): void
    {
        // Reset the notification logger to prevent state leakage between requests
        /** @var NotificationLoggerListener $listener */
        $listener = $event->sandbox->make('flasher.notification_logger_listener');
        $listener->reset();

        // Reset the fallback session static storage to prevent notification leakage
        // when session is not started (e.g., during API requests)
        FallbackSession::reset();
    }
}
