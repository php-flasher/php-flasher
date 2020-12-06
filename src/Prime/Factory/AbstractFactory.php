<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;

/**
 * @method NotificationBuilderInterface type($type, $message = null, array $options = array())
 * @method NotificationBuilderInterface message($message)
 * @method NotificationBuilderInterface options($options)
 * @method NotificationBuilderInterface setOption($name, $value)
 * @method NotificationBuilderInterface unsetOption($name)
 * @method NotificationBuilderInterface handler(string $handler)
 * @method NotificationBuilderInterface with(StampInterface[] $stamps)
 * @method NotificationBuilderInterface withStamp(StampInterface $stamp)
 * @method NotificationBuilderInterface priority($priority)
 * @method NotificationBuilderInterface hops($amount)
 * @method NotificationBuilderInterface keep()
 * @method NotificationBuilderInterface success($message = null, array $options = array())
 * @method NotificationBuilderInterface error($message = null, array $options = array())
 * @method NotificationBuilderInterface info($message = null, array $options = array())
 * @method NotificationBuilderInterface warning($message = null, array $options = array())
 * @method Envelope dispatch(StampInterface[] $stamps)
 * @method NotificationInterface getNotification()
 * @method NotificationInterface getEnvelope()
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
        return new NotificationBuilder($this->getEventDispatcher(), $this->createNotification(), $this->createHandler());
    }

    /**
     * {@inheritdoc}
     */
    public function createNotification()
    {
        return new Notification();
    }

    /**
     * {@inheritdoc}
     */
    public function createHandler()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return get_class($this) === $name;
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
