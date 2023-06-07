<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventListener\AddToStorageListener;
use Flasher\Prime\EventDispatcher\EventListener\EventListenerInterface;
use Flasher\Prime\EventDispatcher\EventListener\RemoveListener;
use Flasher\Prime\EventDispatcher\EventListener\StampsListener;

final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<string, EventListenerInterface[]>
     */
    private array $listeners = [];

    public function __construct()
    {
        $this->addListener(new RemoveListener());
        $this->addListener(new StampsListener());
        $this->addListener(new AddToStorageListener());
    }

    public function dispatch(object $event): object
    {
        $listeners = $this->getListeners($event::class);

        $this->callListeners($listeners, $event);

        return $event;
    }

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

    /**
     * @param  EventListenerInterface[]  $listeners
     */
    private function callListeners(array $listeners, object $event): void
    {
        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }

            if (is_callable($listener)) {
                $listener($event);
            }
        }
    }
}
