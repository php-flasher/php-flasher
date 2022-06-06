<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventListener\AddToStorageListener;
use Flasher\Prime\EventDispatcher\EventListener\EventSubscriberInterface;
use Flasher\Prime\EventDispatcher\EventListener\RemoveListener;
use Flasher\Prime\EventDispatcher\EventListener\StampsListener;

final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<string, EventSubscriberInterface[]>
     */
    private $listeners = array();

    public function __construct()
    {
        $this->addSubscriber(new RemoveListener());
        $this->addSubscriber(new StampsListener());
        $this->addSubscriber(new AddToStorageListener());
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($event)
    {
        $listeners = $this->getListeners(\get_class($event));

        $this->callListeners($listeners, $event); // @phpstan-ignore-line

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($eventName, $listener)
    {
        $this->listeners[$eventName][] = $listener; // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ((array) $subscriber->getSubscribedEvents() as $eventName) {
            $this->addListener($eventName, array($subscriber, '__invoke')); // @phpstan-ignore-line
        }
    }

    /**
     * @param string $eventName
     *
     * @return array<int, EventSubscriberInterface[]>
     */
    public function getListeners($eventName)
    {
        if (\array_key_exists($eventName, $this->listeners)) {
            return $this->listeners[$eventName]; // @phpstan-ignore-line
        }

        return array();
    }

    /**
     * @param callable[] $listeners
     * @param object     $event
     *
     * @return void
     */
    private function callListeners(array $listeners, $event)
    {
        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
            \call_user_func($listener, $event);
        }
    }
}
