<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Typed\Twig;

use Twig\Extension\AbstractExtension;

abstract class FlasherTwigExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return $this->getFlasherFunctions();
    }

    /**
     * @return array
     */
    abstract protected function getFlasherFunctions();
}
