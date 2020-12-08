<?php

namespace Flasher\Prime\Filter;

interface FilterManagerInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $alias
     *
     * @return FilterInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($alias = null);

    /**
     * Register a custom driver creator.
     *
     * @param string                   $alias
     * @param \Closure|FilterInterface $driver
     *
     * @return $this
     */
    public function addDriver($alias, $driver);
}
