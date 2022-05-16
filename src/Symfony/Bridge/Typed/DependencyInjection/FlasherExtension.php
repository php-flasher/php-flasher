<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Typed\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

abstract class FlasherExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return $this->getFlasherAlias();
    }

    /**
     * @return string
     */
    abstract protected function getFlasherAlias();
}
