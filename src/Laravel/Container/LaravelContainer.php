<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Container;

use Flasher\Prime\Container\ContainerInterface;

final class LaravelContainer implements ContainerInterface
{
    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        return app()->make($id);
    }
}
