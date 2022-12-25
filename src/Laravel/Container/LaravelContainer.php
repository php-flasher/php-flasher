<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Container;

use Flasher\Prime\Container\ContainerInterface;
use Illuminate\Container\Container as BaseLaravelContainer;

final class LaravelContainer implements ContainerInterface
{
    /** @var BaseLaravelContainer */
    private $container;

    public function __construct(BaseLaravelContainer $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        return $this->container->make($id);
    }
}
