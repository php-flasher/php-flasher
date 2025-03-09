<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\NotificationEvents;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\PresentationEvent;

/**
 * NotificationLoggerListener - Logs all notifications that are dispatched and displayed.
 *
 * This listener keeps track of all notification envelopes that are dispatched to storage
 * and those that are actually displayed to users. It's useful for debugging and testing
 * to see which notifications were created vs which were actually shown.
 *
 * @internal This class is not part of the public API and may change without notice
 */
final class NotificationLoggerListener implements EventListenerInterface
{
    /**
     * Collection of envelopes that were dispatched to storage.
     */
    private NotificationEvents $dispatchedEnvelopes;

    /**
     * Collection of envelopes that were displayed to users.
     */
    private NotificationEvents $displayedEnvelopes;

    /**
     * Creates a new NotificationLoggerListener instance.
     *
     * Initializes empty collections for tracking dispatched and displayed notifications.
     */
    public function __construct()
    {
        $this->dispatchedEnvelopes = new NotificationEvents();
        $this->displayedEnvelopes = new NotificationEvents();
    }

    /**
     * Resets the listener, clearing all tracked notifications.
     *
     * This is useful for testing or when you want to start with a clean slate.
     */
    public function reset(): void
    {
        $this->dispatchedEnvelopes = new NotificationEvents();
        $this->displayedEnvelopes = new NotificationEvents();
    }

    /**
     * Handles incoming events by delegating to specialized methods.
     *
     * This method implements the __invoke method required by the EventListenerInterface.
     * It routes events to the appropriate handler method based on their type.
     *
     * @param object $event The event to handle
     */
    public function __invoke(object $event): void
    {
        if ($event instanceof PersistEvent) {
            $this->onPersist($event);
        }

        if ($event instanceof PresentationEvent) {
            $this->onPresentation($event);
        }
    }

    /**
     * Handles persist events by logging the notifications being stored.
     *
     * @param PersistEvent $event The persist event
     */
    public function onPersist(PersistEvent $event): void
    {
        $this->dispatchedEnvelopes->add(...$event->getEnvelopes());
    }

    /**
     * Handles presentation events by logging the notifications being displayed.
     *
     * @param PresentationEvent $event The presentation event
     */
    public function onPresentation(PresentationEvent $event): void
    {
        $this->displayedEnvelopes->add(...$event->getEnvelopes());
    }

    /**
     * Gets the collection of envelopes that were dispatched to storage.
     *
     * @return NotificationEvents Collection of dispatched notification envelopes
     */
    public function getDispatchedEnvelopes(): NotificationEvents
    {
        return $this->dispatchedEnvelopes;
    }

    /**
     * Gets the collection of envelopes that were displayed to users.
     *
     * @return NotificationEvents Collection of displayed notification envelopes
     */
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
