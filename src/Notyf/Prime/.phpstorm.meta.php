<?php

namespace PHPSTORM_META;

expectedArguments(\notyf(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Notyf\Prime\notyf(), 1, 'success', 'error', 'info', 'warning');

expectedArguments(\Flasher\Notyf\Prime\NotyfBuilder::duration(), 0, 1000, 2000, 3000, 4000, 5000);
expectedArguments(\Flasher\Notyf\Prime\NotyfBuilder::position(), 0, 'x', 'y');
expectedArguments(\Flasher\Notyf\Prime\NotyfBuilder::position(), 1, 'top', 'right', 'bottom', 'left', 'center');

override(\Flasher\Prime\FlasherInterface::use(), map(['notyf' => \Flasher\Notyf\Prime\NotyfInterface::class]));
override(\Flasher\Prime\FlasherInterface::create(), map(['notyf' => \Flasher\Notyf\Prime\NotyfInterface::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher.notyf' => \Notyf\Notyf\Prime\NotyfInterface::class]));

