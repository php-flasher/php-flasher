<?php

namespace Flasher\Prime\EventDispatcher;

use Flasher\Prime\EventDispatcher\Event\StoppableEventInterface;
use Flasher\Prime\EventDispatcher\EventSubscriber\EventSubscriberInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = array();

    private $sorted = array();

    /**
     * @inheritDoc
     */
    public function dispatch($event)
    {
        $listeners = $this->getListeners(get_class($event));

        $this->callListeners($listeners, $event);

        return $event;
    }

    /**
     * {@inheritdoc}
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
     * @param callable[]     $listeners
     * @param object $event
     */
    protected function callListeners(array $listeners, $event)
    {
        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
            $listener($event, $this);
        }
    }

    /**
     * @inheritDoc
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ((array) $subscriber->getSubscribedEvents() as $eventName => $params) {
            if (\is_string($params)) {
                $this->addListener($eventName, array($subscriber, $params));
            } elseif (\is_string($params[0])) {
                $this->addListener($eventName, array($subscriber, $params[0]), isset($params[1]) ? $params[1] : 0);
            } else {
                foreach ($params as $listener) {
                    $this->addListener($eventName, array($subscriber, $listener[0]), isset($listener[1]) ? $listener[1] : 0);
                }
            }
        }
    }
}
