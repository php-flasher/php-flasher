<?php

declare(strict_types=1);

namespace Flasher\Laravel\EventListener;

use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Laravel\Octane\Events\RequestReceived;

final readonly class OctaneListener
{
    public function __invoke(RequestReceived $event): void
    {
        /** @var NotificationLoggerListener $listener */
        $listener = $event->sandbox->make('flasher.notification_logger_listener');
        $listener->reset();
    }
}
