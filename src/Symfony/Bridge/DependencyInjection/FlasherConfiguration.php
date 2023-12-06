<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\DependencyInjection;

use Flasher\Symfony\Bridge\Bridge;

$class = Bridge::versionCompare('6.4', '>=')
    ? 'Flasher\Symfony\Bridge\Typed\DependencyInjection\FlasherConfiguration'
    : 'Flasher\Symfony\Bridge\Legacy\DependencyInjection\FlasherConfiguration';

class_alias($class, 'Flasher\Symfony\Bridge\DependencyInjection\FlasherConfiguration');

if (false) { /** @phpstan-ignore-line */
    abstract class FlasherConfiguration
    {
        /**
         * @return string
         */
        abstract protected function getFlasherConfigTreeBuilder();
    }
}
