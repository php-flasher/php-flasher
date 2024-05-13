<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\EventDispatcher\Event\PresentationEvent;

final class NotificationLoggerListener implements EventListenerInterface
{
    private NotificationEvents $events;

    public function __construct()
    {
        $this->events = new NotificationEvents();
    }

    public function reset(): void
    {
        $this->events = new NotificationEvents();
    }

    public function __invoke(PresentationEvent $event): void
    {
        $this->events->add(...$event->getEnvelopes());
    }

    public function getEvents(): NotificationEvents
    {
        return $this->events;
    }

    public function getSubscribedEvents(): string
    {
        return PresentationEvent::class;
    }
}
