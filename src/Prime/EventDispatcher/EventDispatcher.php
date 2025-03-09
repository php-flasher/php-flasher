<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventListener\AddToStorageListener;
use Flasher\Prime\EventDispatcher\EventListener\AttachDefaultStampsListener;
use Flasher\Prime\EventDispatcher\EventListener\EnvelopeRemovalListener;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

/**
 * EventDispatcher - Default implementation of the event dispatcher interface.
 *
 * This class provides the core event dispatching functionality for PHPFlasher.
 * It allows registering listeners for specific events and dispatches events
 * to all relevant listeners. It also comes pre-configured with the essential
 * system listeners that implement core notification behaviors.
 *
 * Design patterns:
 * - Observer: Implements the observer pattern for event notification
 * - Chain of Responsibility: Passes events through a chain of listeners
 */
final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * Mapping of event names to their registered listeners.
     *
     * @var array<string, EventListenerInterface[]>
     */
    private array $listeners = [];

    /**
     * Creates a new EventDispatcher with default system listeners.
     *
     * This constructor automatically registers the core system listeners
     * that are essential for proper notification handling:
     * - EnvelopeRemovalListener: Manages notification lifetime across requests
     * - AttachDefaultStampsListener: Adds required stamps to notifications
     * - AddToStorageListener: Filters notifications before storage
     */
    public function __construct()
    {
        $this->addListener(new EnvelopeRemovalListener());
        $this->addListener(new AttachDefaultStampsListener());
        $this->addListener(new AddToStorageListener());
    }

    /**
     * {@inheritdoc}
     *
     * This implementation supports event propagation stopping for events
     * that implement StoppableEventInterface. It calls each listener in
     * registration order until all listeners are called or propagation is stopped.
     *
     * @throws \InvalidArgumentException If a listener is not callable
     */
    public function dispatch(object $event): object
    {
        $listeners = $this->getListeners($event::class);

        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }

            if (!\is_callable($listener)) {
                throw new \InvalidArgumentException(\sprintf('Listener "%s" is not callable. Listeners must implement __invoke method.', $listener::class));
            }

            $listener($event);
        }

        return $event;
    }

    /**
     * {@inheritdoc}
     *
     * This implementation registers a listener for all events it declares
     * interest in through its getSubscribedEvents() method.
     */
    public function addListener(EventListenerInterface $listener): void
    {
        foreach ((array) $listener->getSubscribedEvents() as $eventName) {
            $this->listeners[$eventName][] = $listener;
        }
    }

    public function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}
