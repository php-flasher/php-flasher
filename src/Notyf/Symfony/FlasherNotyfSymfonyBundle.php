<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherNotyfSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new NotyfPlugin();
    }
}
