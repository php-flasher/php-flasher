<?php

namespace PHPSTORM_META;

$mapping = [
    '' => '@',

    'Flasher\Prime\Config\ConfigInterface' => \Flasher\Laravel\Config\Config::class,
    'Flasher\Prime\EventDispatcher\EventDispatcherInterface' => \Flasher\Prime\EventDispatcher\EventDispatcher::class,
    'Flasher\Prime\Factory\NotificationFactoryInterface' => \Flasher\Prime\Factory\NotificationFactory::class,
    'Flasher\Prime\Filter\FilterInterface' => \Flasher\Prime\Filter\Filter::class,
    'Flasher\Prime\FlasherInterface' => \Flasher\Prime\Flasher::class,
    'Flasher\Prime\Response\ResponseManagerInterface' => \Flasher\Prime\Response\ResponseManager::class,
    'Flasher\Prime\Storage\StorageInterface' => \Flasher\Laravel\Storage\Storage::class,
    'Flasher\Prime\Storage\StorageManagerInterface' => \Flasher\Prime\Storage\StorageManager::class,
    'Flasher\Prime\Template\EngineInterface' => \Flasher\Laravel\Template\BladeEngine::class,

    'flasher' => \Flasher\Prime\Flasher::class,
    'flasher.config' => \Flasher\Laravel\Config\Config::class,
    'flasher.event_dispatcher' => \Flasher\Prime\EventDispatcher\EventDispatcher::class,
    'flasher.filter' => \Flasher\Prime\Filter\Filter::class,
    'flasher.notification_factory' => \Flasher\Prime\Factory\NotificationFactory::class,
    'flasher.template' => \Flasher\Prime\Factory\TemplateFactory::class,
    'flasher.noty' => \Flasher\Noty\Prime\NotyFactory::class,
    'flasher.notyf' => \Flasher\Notyf\Prime\NotyfFactory::class,
    'flasher.pnotify' => \Flasher\Pnotify\Prime\PnotifyFactory::class,
    'flasher.resource_manager' => \Flasher\Prime\Response\Resource\ResourceManager::class,
    'flasher.response_manager' => \Flasher\Prime\Response\ResponseManager::class,
    'flasher.storage' => \Flasher\Laravel\Storage\Storage::class,
    'flasher.storage_manager' => \Flasher\Prime\Storage\StorageManager::class,
    'flasher.sweet_alert' => \Flasher\SweetAlert\Prime\SweetAlertFactory::class,
    'flasher.template_engine' => \Flasher\Laravel\Template\BladeEngine::class,
    'flasher.toastr' => \Flasher\Toastr\Prime\ToastrFactory::class,

    'flasher.template.tailwindcss' => \Flasher\Prime\Factory\TemplateFactory::class,
    'flasher.template.tailwindcss_bg' => \Flasher\Prime\Factory\TemplateFactory::class,
    'flasher.template.boostrap' => \Flasher\Prime\Factory\TemplateFactory::class,
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
