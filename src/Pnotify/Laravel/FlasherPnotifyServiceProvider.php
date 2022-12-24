<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Pnotify\Prime\PnotifyPlugin;

final class FlasherPnotifyServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new PnotifyPlugin();
    }
}
