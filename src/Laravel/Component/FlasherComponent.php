<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Component;

use Illuminate\View\Component;

class FlasherComponent extends Component
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        @trigger_error('Since php-flasher/flasher-laravel v1.6.0: Using flasher blade component is deprecated and will be removed in v2.0. PHPFlasher will render notification automatically', \E_USER_DEPRECATED);

        return '';
    }
}
