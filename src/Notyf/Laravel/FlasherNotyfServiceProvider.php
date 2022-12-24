<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Notyf\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Notyf\Prime\NotyfPlugin;

final class FlasherNotyfServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new NotyfPlugin();
    }
}
