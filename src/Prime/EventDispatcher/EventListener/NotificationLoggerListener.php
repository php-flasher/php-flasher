<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\PresentationEvent;

/**
 * @internal
 */
final class NotificationLoggerListener implements EventListenerInterface
{
    private NotificationEvents $dispatchedEnvelopes;

    private NotificationEvents $displayedEnvelopes;

    public function __construct()
    {
        $this->dispatchedEnvelopes = new NotificationEvents();
        $this->displayedEnvelopes = new NotificationEvents();
    }

    public function reset(): void
    {
        $this->dispatchedEnvelopes = new NotificationEvents();
        $this->displayedEnvelopes = new NotificationEvents();
    }

    public function __invoke(object $event): void
    {
        if ($event instanceof PersistEvent) {
            $this->onPersist($event);
        }

        if ($event instanceof PresentationEvent) {
            $this->onPresentation($event);
        }
    }

    public function onPersist(PersistEvent $event): void
    {
        $this->dispatchedEnvelopes->add(...$event->getEnvelopes());
    }

    public function onPresentation(PresentationEvent $event): void
    {
        $this->displayedEnvelopes->add(...$event->getEnvelopes());
    }

    public function getDispatchedEnvelopes(): NotificationEvents
    {
        return $this->dispatchedEnvelopes;
    }

    public function getDisplayedEnvelopes(): NotificationEvents
    {
        return $this->displayedEnvelopes;
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            PersistEvent::class,
            PresentationEvent::class,
        ];
    }
}
