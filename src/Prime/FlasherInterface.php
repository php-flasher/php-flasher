<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\FlasherFactoryInterface;
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
 * @method Envelope flash(StampInterface[] $stamps)
 * @method Envelope addFlash(string|Envelope $type, string $message = null, array $options = array())
 * @method NotificationInterface getNotification()
 * @method NotificationInterface getEnvelope()
 */
interface FlasherInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $name
     * @param array       $context
     *
     * @return FlasherFactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array());

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|FlasherFactoryInterface $driver
     *
     * @return $this
     */
    public function addDriver($driver);
}
