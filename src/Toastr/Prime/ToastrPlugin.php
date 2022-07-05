<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Plugin\Plugin;

class ToastrPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js',
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.1.1/dist/flasher-toastr.min.js',
        );
    }
}
