<?php

namespace PHPSTORM_META;

expectedArguments(\toastr(), 1, 'success', 'error', 'info', 'warning');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::showMethod(), 0, 'fadeIn', 'fadeOut', 'slideDown', 'show');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::hideMethod(), 0, 'fadeIn', 'fadeOut', 'slideDown', 'show');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::showEasing(), 0, 'swing', 'linear');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::hideEasing(), 0, 'swing', 'linear');
expectedArguments(\Flasher\Toastr\Prime\ToastrBuilder::positionClass(), 0, 'toast-top-right', 'toast-top-center', 'toast-bottom-center', 'toast-top-full-width', 'toast-bottom-full-width', 'toast-top-left', 'toast-bottom-right', 'toast-bottom-left');

override(\Flasher\Prime\FlasherInterface::use(), map(['toastr' => \Flasher\Toastr\Prime\Toastr::class]));
override(\Flasher\Prime\Container\FlasherContainer::create(), map(['flasher.toastr' => \Flasher\Toastr\Prime\ToastrInterface::class]));
