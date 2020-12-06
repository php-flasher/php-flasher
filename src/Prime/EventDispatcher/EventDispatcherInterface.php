<?php

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;

interface EventDispatcherInterface
{
    /**
     * @param string   $eventName
     * @param callable $listener
     * @param int      $priority
     */
    public function addListener($eventName, $listener, $priority = 0);

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);

    /**
     * @param string $eventName
     *
     * @return array
     */
    public function getListeners($eventName);

    /**
     * @param object $event
     *
     * @return object
     */
    public function dispatch($event);
}
