<?php

namespace Flasher\Prime\Filter;

interface FilterManagerInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $name
     * @param array       $context
     *
     * @return FilterInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array());

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|FilterInterface $driver
     *
     * @return $this
     */
    public function addDriver($driver);
}
