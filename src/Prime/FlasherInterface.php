<?php

namespace Flasher\Prime;

use Flasher\Prime\Factory\FlasherFactoryInterface;

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
