<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventListener\AddToStorageListener;
use Flasher\Prime\EventDispatcher\EventListener\AttachDefaultStampsListener;
use Flasher\Prime\EventDispatcher\EventListener\EnvelopeRemovalListener;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<string, EventListenerInterface[]>
     */
    private array $listeners = [];

    public function __construct()
    {
        $this->addListener(new EnvelopeRemovalListener());
        $this->addListener(new AttachDefaultStampsListener());
        $this->addListener(new AddToStorageListener());
    }

    public function dispatch(object $event): object
    {
        $listeners = $this->getListeners($event::class);

        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }

            if (!\is_callable($listener)) {
                throw new \InvalidArgumentException(sprintf('Listener "%s" is not callable. Listeners must implement __invoke method.', $listener::class));
            }

            $listener($event);
        }

        return $event;
    }

    public function addListener(EventListenerInterface $listener): void
    {
        foreach ((array) $listener->getSubscribedEvents() as $eventName) {
            $this->listeners[$eventName][] = $listener;
        }
    }

    /**
     * @return EventListenerInterface[]
     */
    public function getListeners(string $eventName): array
    {
        return $this->listeners[$eventName] ?? [];
    }
}
