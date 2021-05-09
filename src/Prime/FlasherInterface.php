<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\NotificationFactoryInterface;
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
     * @return NotificationFactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function create($alias = null);

    /**
     * Register a custom driver creator.
     *
     * @param string           $alias
     *
     * @return $this
     */
    public function addFactory($alias, NotificationFactoryInterface $factory);
}
