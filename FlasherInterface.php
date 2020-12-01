<?php

namespace Flasher\Prime;

interface FlasherInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $name
     * @param array       $context
     *
     * @return NotifyFactoryInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array());

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|NotifyFactoryInterface $driver
     *
     * @return $this
     */
    public function addDriver($driver);
}
