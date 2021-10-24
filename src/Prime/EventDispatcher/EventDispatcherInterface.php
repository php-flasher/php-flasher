<?php

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;

interface EventDispatcherInterface
{
    /**
     * @param object $event
     *
     * @return object
     */
    public function dispatch($event);

    /**
     * @param string   $eventName
     * @param callable $listener
     * @param int      $priority
     *
     * @return void
     */
    public function addListener($eventName, $listener, $priority = 0);

    /**
     * @return void
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);
}
