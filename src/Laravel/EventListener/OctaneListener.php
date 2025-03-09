<?php

declare(strict_types=1);

namespace Flasher\Laravel\EventListener;

use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Laravel\Octane\Events\RequestReceived;

/**
 * OctaneListener - Resets notification logger between Octane requests.
 *
 * This listener ensures that notifications from previous requests don't
 * leak into new requests when running Laravel Octane, which keeps workers
 * alive between requests.
 *
 * Design patterns:
 * - Observer: Observes Octane request events
 * - State Reset: Cleans up state between stateful worker requests
 */
final readonly class OctaneListener
{
    /**
     * Handle the Octane RequestReceived event.
     *
     * Resets the notification logger to ensure clean state for the new request.
     *
     * @param RequestReceived $event The Octane request received event
     */
    public function handle(RequestReceived $event): void
    {
        /** @var NotificationLoggerListener $listener */
        $listener = $event->sandbox->make('flasher.notification_logger_listener');
        $listener->reset();
    }
}
