<?php

namespace Flasher\Prime\Presenter;

interface PresenterManagerInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $name
     * @param array       $context
     *
     * @return PresenterInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array());

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|PresenterInterface $driver
     *
     * @return $this
     */
    public function addDriver($driver);
}
