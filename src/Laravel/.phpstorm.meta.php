<?php

namespace PHPSTORM_META;

$mapping = [
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
];

override(new \Illuminate\Contracts\Container\Container, map($mapping));
override(\Illuminate\Container\Container::makeWith(0), map($mapping));
override(\Illuminate\Contracts\Container\Container::get(0), map($mapping));
override(\Illuminate\Contracts\Container\Container::make(0), map($mapping));
override(\Illuminate\Contracts\Container\Container::makeWith(0), map($mapping));
override(\App::get(0), map($mapping));
override(\App::make(0), map($mapping));
override(\App::makeWith(0), map($mapping));
override(\app(0), map($mapping));
override(\resolve(0), map($mapping));
override(\Psr\Container\ContainerInterface::get(0), map($mapping));
