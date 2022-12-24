<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Toastr\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function createPlugin()
    {
        return new ToastrPlugin();
    }
}
