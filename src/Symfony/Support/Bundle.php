<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Bridge\FlasherBundle;

abstract class Bundle extends FlasherBundle
{
    /**
     * @return PluginInterface
     */
    abstract protected function createPlugin();

    protected function getFlasherContainerExtension()
    {
        return new Extension($this->createPlugin());
    }
}
