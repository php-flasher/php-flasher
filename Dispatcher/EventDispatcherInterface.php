<?php

namespace Flasher\Prime\Dispatcher;

use Flasher\Prime\Dispatcher\Event\EventInterface;
use Flasher\Prime\Dispatcher\Listener\ListenerInterface;

interface EventDispatcherInterface
{
    /**
     * @param string            $eventName
     * @param ListenerInterface $listener
     */
    public function addListener($eventName, ListenerInterface $listener);

    /**
     * @param EventInterface $event
     * @param string|null    $eventName
     *
     * @return EventInterface
     */
    public function dispatch(EventInterface $event, $eventName = null);
}
