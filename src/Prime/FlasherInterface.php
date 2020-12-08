<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\FlasherFactoryInterface;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
interface FlasherInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $alias
     *
     * @return FlasherFactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($alias = null);

    /**
     * Register a custom driver creator.
     *
     * @param string
     * @param \Closure|FlasherFactoryInterface $driver
     *
     * @return $this
     */
    public function addDriver($alias, $driver);
}
