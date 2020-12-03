<?php

namespace Flasher\Prime\Dispatcher;

use Flasher\Prime\Dispatcher\Event\EventInterface;
use Flasher\Prime\Dispatcher\Listener\ListenerInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = array();
    private $sorted = array();

    /**
     * @inheritDoc
     */
    public function addListener($eventName, ListenerInterface $listener, $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $listener;
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

        if (!isset($this->sorted[$eventName])) {
            $this->sortListeners($eventName);
        }

        return $this->sorted[$eventName];
    }

    /**
     * @param $eventName
     */
    private function sortListeners($eventName)
    {
        krsort($this->listeners[$eventName]);
        $this->sorted[$eventName] = array();

        foreach ($this->listeners[$eventName] as $listeners) {
            foreach ($listeners as $k => $listener) {
                $this->sorted[$eventName][] = $listener;
            }
        }
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
