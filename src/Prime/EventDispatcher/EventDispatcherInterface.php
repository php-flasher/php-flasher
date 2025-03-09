<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

/**
 * EventDispatcherInterface - Contract for event dispatching services.
 *
 * This interface defines the essential operations for dispatching events to
 * registered listeners. It provides a simple but powerful event system where
 * listeners can react to various events in the notification lifecycle.
 *
 * Design pattern: Observer - Defines a one-to-many dependency between objects
 * where multiple observers are notified of state changes in the subject.
 */
interface EventDispatcherInterface
{
    /**
     * Dispatches an event to all registered listeners.
     *
     * This method notifies all listeners subscribed to the event's class.
     * It passes the event object to each listener for processing and returns
     * the potentially modified event object.
     *
     * @template T of object
     *
     * @param T $event The event to dispatch
     *
     * @return T The event after it has been processed by all listeners
     *
     * @phpstan-param T $event
     *
     * @phpstan-return T
     */
    public function dispatch(object $event): object;

    /**
     * Registers a listener with the dispatcher.
     *
     * This method registers a listener that will be notified when events
     * it's interested in are dispatched.
     *
     * @param EventListenerInterface $listener The listener to register
     */
    public function addListener(EventListenerInterface $listener): void;

    /**
     * Gets all listeners for a specific event.
     *
     * This method retrieves all listeners that are registered for the given event name.
     *
     * @param string $eventName The event class name
     *
     * @return EventListenerInterface[] Array of listeners for the event
     */
    public function getListeners(string $eventName): array;
}
