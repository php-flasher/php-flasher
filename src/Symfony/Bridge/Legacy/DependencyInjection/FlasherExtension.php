<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Legacy\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

abstract class FlasherExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->getFlasherAlias();
    }

    /**
     * @return string
     */
    abstract protected function getFlasherAlias();
}
