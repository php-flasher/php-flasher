<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Plugin\Plugin;

class SweetAlertPlugin extends Plugin
{
    public function getAlias()
    {
        return 'sweetalert';
    }

    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'cdn' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.2.4/dist/flasher-sweetalert.min.js',
            ),
            'local' => array(
                '/vendor/flasher/flasher-sweetalert.min.js',
            ),
        );
    }
}
