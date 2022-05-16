<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\DependencyInjection;

use Flasher\Symfony\Bridge\Bridge;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

$class = Bridge::isLegacy()
    ? 'Flasher\Symfony\Bridge\Legacy\DependencyInjection\FlasherExtension'
    : 'Flasher\Symfony\Bridge\Typed\DependencyInjection\FlasherExtension';

class_alias($class, 'Flasher\Symfony\Bridge\DependencyInjection\FlasherExtension');

if (false) { /** @phpstan-ignore-line */
    abstract class FlasherExtension extends Extension
    {
        /**
         * @return string
         */
        abstract protected function getFlasherAlias();
    }
}
