<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Bridge\Command;

use Flasher\Symfony\Bridge\Bridge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$class = Bridge::versionCompare('6.4', '>=')
    ? 'Flasher\Symfony\Bridge\Typed\Command\FlasherCommand'
    : 'Flasher\Symfony\Bridge\Legacy\Command\FlasherCommand';

class_alias($class, 'Flasher\Symfony\Bridge\Command\FlasherCommand');

if (false) { /** @phpstan-ignore-line */
    abstract class FlasherCommand
    {
        /**
         * @return int
         */
        abstract protected function flasherExecute(InputInterface $input, OutputInterface $output);
    }
}
