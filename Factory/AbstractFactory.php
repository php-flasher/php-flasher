<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
abstract class AbstractFactory implements FlasherFactoryInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new NotificationBuilder($this->getEventDispatcher(), new Notification(), 'default');
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        return call_user_func_array(array($this->createNotificationBuilder(), $method), $parameters);
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
}
