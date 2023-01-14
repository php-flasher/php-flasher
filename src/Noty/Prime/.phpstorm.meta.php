<?php

namespace PHPSTORM_META;

expectedArguments(\noty(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::layout(), 0, 'top', 'topLeft', 'topCenter', 'topRight', 'center', 'centerLeft', 'centerRight', 'bottom', 'bottomLeft', 'bottomCenter', 'bottomRight');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::theme(), 0, 'relax', 'mint', 'metroui');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::timeout(), 0, false, 1000, 3000, 3500, 5000);
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::closeWith(), 0, 'click', 'button', array('click', 'button'));
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::animation(), 0, 'open', 'close');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::sounds(), 0, 'sources', 'volume', 'conditions');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::docTitle(), 0, 'conditions');
expectedArguments(\Flasher\Noty\Prime\NotyBuilder::queue(), 0, 'global');

override(\Flasher\Prime\FlasherInterface::create(), map([
    'noty' => \Flasher\Noty\Prime\NotyFactory::class
]));

override(\Flasher\Prime\FlasherInterface::using(), map([
    'noty' => \Flasher\Noty\Prime\NotyFactory::class
]));
