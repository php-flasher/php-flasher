<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Notification\NotificationBuilder;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\NotificationInterface;

/**
 * @method NotificationBuilderInterface type($type, $message = null, array $options = array())
 * @method NotificationBuilderInterface message($message)
 * @method NotificationBuilderInterface options($options)
 * @method NotificationBuilderInterface setOption($name, $value)
 * @method NotificationBuilderInterface unsetOption($name)
 * @method NotificationBuilderInterface success($message = null, array $options = array())
 * @method NotificationBuilderInterface error($message = null, array $options = array())
 * @method NotificationBuilderInterface info($message = null, array $options = array())
 * @method NotificationBuilderInterface warning($message = null, array $options = array())
 * @method NotificationInterface getNotification()
 */
abstract class AbstractFlasher implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNotificationBuilder()
    {
        return new NotificationBuilder($this->createNotification());
    }

    /**
     * {@inheritdoc}
     */
    public function createNotification()
    {
        return new Notification();
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
}
