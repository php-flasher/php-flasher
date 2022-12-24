<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Symfony;

use Flasher\Pnotify\Prime\PnotifyPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherPnotifySymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new PnotifyPlugin();
    }
}
