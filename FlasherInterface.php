<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\FactoryInterface;
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
     * @return FactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function create($alias = null);

    /**
     * Register a custom driver creator.
     *
     * @param string
     * @param FactoryInterface $factory
     *
     * @return $this
     */
    public function addFactory($alias, FactoryInterface $factory);
}
