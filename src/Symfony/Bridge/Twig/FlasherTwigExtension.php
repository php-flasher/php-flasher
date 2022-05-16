<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Twig;

use Flasher\Symfony\Bridge\Bridge;
use Twig\TwigFunction;

$class = Bridge::isLegacy()
    ? 'Flasher\Symfony\Bridge\Legacy\Twig\FlasherTwigExtension'
    : 'Flasher\Symfony\Bridge\Typed\Twig\FlasherTwigExtension';

class_alias($class, 'Flasher\Symfony\Bridge\Twig\FlasherTwigExtension');

if (false) { /** @phpstan-ignore-line */
    abstract class FlasherTwigExtension
    {
        /**
         * @return TwigFunction[]
         */
        abstract protected function getFlasherFunctions();
    }
}
