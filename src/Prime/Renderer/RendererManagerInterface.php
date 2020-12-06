<?php

namespace Flasher\Prime\Renderer;

interface RendererManagerInterface
{
    /**
     * Get a driver instance.
     *
     * @param string|null $name
     * @param array       $context
     *
     * @return RendererInterface
     *
     * @throws \InvalidArgumentException
     */
    public function make($name = null, array $context = array());

    /**
     * Register a custom driver creator.
     *
     * @param \Closure|RendererInterface $driver
     *
     * @return $this
     */
    public function addDriver($driver);
}
