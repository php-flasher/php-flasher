<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Toastr\Symfony;

use Flasher\Symfony\Support\Bundle;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    /**
     * {@inheritdoc}
     */
    public function createPlugin()
    {
        return new ToastrPlugin();
    }
}
