<?php

declare(strict_types=1);

use Flasher\Prime\Config\Config;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\Filter\FilterFactory;
use Flasher\Prime\Storage\StorageBag;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Symfony\Storage\SessionBag;
use Flasher\Symfony\Translation\Translator;
use Flasher\Symfony\Twig\FlasherTwigExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('flasher.config', Config::class)
        ->args([abstract_arg('config')]);

    $services->set('flasher.storage_bag', SessionBag::class)
        ->args([service('request_stack')]);

    $services->set('flasher.storage', StorageBag::class)
        ->args([service('flasher.storage_bag')]);

    $services->set('flasher.event_dispatcher', EventDispatcher::class);

    $services->set('flasher.filter_factory', FilterFactory::class);

    $services->set('flasher.storage_manager', StorageManager::class)
        ->args([
            service('flasher.storage'),
            service('flasher.event_dispatcher'),
            service('flasher.filter_factory'),
            abstract_arg('config.filter'),
        ]);

    $services->set('flasher.resource_manager', ResourceManager::class)
        ->args([service('flasher.config')]);

    $services->set('flasher.response_manager', ResponseManager::class)
        ->args([
            service('flasher.resource_manager'),
            service('flasher.storage_manager'),
            service('flasher.event_dispatcher'),
        ]);

    $services->alias('flasher', FlasherInterface::class)
        ->set('flasher', Flasher::class)
        ->public()
        ->args([
            abstract_arg('config.default'),
            service('flasher.response_manager'),
            service('flasher.storage_manager'),
        ]);

    $services->set('flasher.notification_factory', NotificationFactory::class)
        ->args([service('flasher.storage_manager')]);

    $services->set('flasher.translator', Translator::class)
        ->args([service('translator')->ignoreOnInvalid()]);

    $services->set('flasher.translation_listener', TranslationListener::class)
        ->args([
            service('flasher.translator')->nullOnInvalid(),
            abstract_arg('config.auto_translate'),
        ])
        ->tag('flasher.event_listener');

    $services->set('flasher.preset_listener', ApplyPresetListener::class)
        ->args([
            abstract_arg('config.presets'),
        ])
        ->tag('flasher.event_listener');

    $services->set('flasher.twig_extension', FlasherTwigExtension::class)
        ->args([service('flasher')])
        ->tag('twig.extension');
};
