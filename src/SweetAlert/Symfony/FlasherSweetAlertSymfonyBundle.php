<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\SweetAlert\Symfony;

use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherSweetAlertSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritDoc}
     */
    public function createPlugin()
    {
        return new SweetAlertPlugin();
    }
}
