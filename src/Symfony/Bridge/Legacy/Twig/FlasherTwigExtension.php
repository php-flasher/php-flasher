<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Legacy\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

abstract class FlasherTwigExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return $this->getFlasherFunctions();
    }

    /**
     * @return TwigFunction[]
     */
    abstract protected function getFlasherFunctions();
}
