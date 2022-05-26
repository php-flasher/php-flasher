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
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.0.16/dist/flasher-sweetalert.min.js',
        );
    }
}
