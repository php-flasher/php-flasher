<?php

namespace PHPSTORM_META;

override(new \Illuminate\Contracts\Container\Container, map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\Illuminate\Container\Container::makeWith(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\Illuminate\Contracts\Container\Container::get(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\Illuminate\Contracts\Container\Container::make(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\Illuminate\Contracts\Container\Container::makeWith(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\App::get(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\App::make(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\App::makeWith(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\app(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\resolve(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));

override(\Psr\Container\ContainerInterface::get(0), map([
    '' => '@',
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.sweetalert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\FlasherFactory::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,
]));
