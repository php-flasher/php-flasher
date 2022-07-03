<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Twig;

use Flasher\Symfony\Bridge\Twig\FlasherTwigExtension as BaseFlasherTwigExtension;
use Twig\TwigFunction;

final class FlasherTwigExtension extends BaseFlasherTwigExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFlasherFunctions()
    {
        return array(
            new TwigFunction('flasher_render', array($this, 'render')),
        );
    }

    /**
     * @return string
     */
    public function render()
    {
        return '';
    }
}
