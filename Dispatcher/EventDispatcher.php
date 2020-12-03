<?php

namespace Flasher\Prime\Dispatcher;

use Flasher\Prime\Dispatcher\Event\EventInterface;
use Flasher\Prime\Dispatcher\Listener\ListenerInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = array();

    /**
     * @inheritDoc
     */
    public function addListener($eventName, ListenerInterface $listener)
    {
        $this->listeners[$eventName][] = $listener;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(EventInterface $event, $eventName = null)
    {
        $eventName = $eventName ?: get_class($event);

        $listeners = $this->getListeners($eventName);

        $this->callListeners($listeners, $event);

        return $event;
    }

    /**
     * @param string $eventName
     *
     * @return ListenerInterface[]
     */
    public function getListeners($eventName)
    {
        if (empty($this->listeners[$eventName])) {
            return array();
        }

        return $this->listeners[$eventName];
    }

    /**
     * @param ListenerInterface[] $listeners
     * @param EventInterface      $event
     */
    protected function callListeners(array $listeners, $event)
    {
        foreach ($listeners as $listener) {
            $listener->handle($event);
        }
    }
}
