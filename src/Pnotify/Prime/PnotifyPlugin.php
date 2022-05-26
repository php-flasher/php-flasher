<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Plugin\Plugin;

class PnotifyPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@1.0.16/dist/flasher-pnotify.min.js',
        );
    }
}
