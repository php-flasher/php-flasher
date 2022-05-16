<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherNotySymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritDoc}
     */
    protected function createPlugin()
    {
        return new NotyPlugin();
    }
}
