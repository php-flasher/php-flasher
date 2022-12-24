<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Noty\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Noty\Prime\NotyPlugin;

final class FlasherNotyServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new NotyPlugin();
    }
}
