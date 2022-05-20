<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Noty\Prime;

use Flasher\Prime\Plugin\Plugin;

class NotyPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.0.8/dist/flasher-noty.min.js',
        );
    }
}
