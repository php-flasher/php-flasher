<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Bridge\Command;

use Flasher\Laravel\Support\Laravel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$class = Laravel::isVersion('11.0', '>=')
    ? 'Flasher\Laravel\Bridge\Typed\Command\FlasherCommand'
    : 'Flasher\Laravel\Bridge\Legacy\Command\FlasherCommand';

class_alias($class, 'Flasher\Laravel\Bridge\Command\FlasherCommand');

if (false) { /** @phpstan-ignore-line */
    abstract class FlasherCommand
    {
        /**
         * @return int
         */
        abstract protected function flasherExecute(InputInterface $input, OutputInterface $output);
    }
}
