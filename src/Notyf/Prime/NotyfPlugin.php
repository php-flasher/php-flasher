<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Plugin\Plugin;

class NotyfPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.0.9/dist/flasher-notyf.min.js',
        );
    }
}
