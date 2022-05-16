<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
     *
     * @return void
     */
    public function addListener($eventName, $listener);

    /**
     * @return void
     */
    public function addSubscriber(EventSubscriberInterface $subscriber);
}
