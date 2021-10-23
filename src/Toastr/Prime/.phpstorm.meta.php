<?php

namespace PHPSTORM_META;

expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::showMethod(), 0, 'fadeIn', 'fadeOut', 'slideDown', 'show');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::hideMethod(), 0, 'fadeIn', 'fadeOut', 'slideDown', 'show');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::showEasing(), 0, 'swing', 'linear');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::hideEasing(), 0, 'swing', 'linear');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::positionClass(), 0, 'toast-top-right', 'toast-top-center', 'toast-bottom-center', 'toast-top-full-width', 'toast-bottom-full-width', 'toast-top-left', 'toast-bottom-right', 'toast-bottom-left');

$mapping = map([
    'toastr' => \Flasher\Toastr\Prime\ToastrFactory::class
]);

override(\Flasher\Prime\FlasherInterface::create(), map($mapping));
override(\Flasher\Prime\FlasherInterface::using(), map($mapping));
