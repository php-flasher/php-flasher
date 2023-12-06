<?php

declare(strict_types=1);

use Flasher\Prime\Config\Config;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\Filter\FilterFactory;
use Flasher\Prime\Storage\Storage;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Symfony\EventListener\FlasherListener;
use Flasher\Symfony\EventListener\SessionListener;
use Flasher\Symfony\Storage\SessionBag;
use Flasher\Symfony\Translation\Translator;
use Flasher\Symfony\Twig\FlasherTwigExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\abstract_arg;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('flasher', Flasher::class)
            ->public()
            ->args([
                abstract_arg('config.default'),
                service('flasher.response_manager'),
                service('flasher.storage_manager'),
            ])
            ->alias(FlasherInterface::class, 'flasher')

        ->set('flasher.flasher_listener', FlasherListener::class)
            ->args([service('flasher.response_extension')])
            ->tag('kernel.event_listener', ['event' => 'kernel.response', 'priority' => -256])

        ->set('flasher.twig_extension', FlasherTwigExtension::class)
            ->args([service('flasher')])
            ->tag('twig.extension')

        ->set('flasher.session_listener', SessionListener::class)
            ->args([service('flasher.request_extension')])
            ->tag('kernel.event_listener', ['event' => 'kernel.response'])

        ->set('flasher.translation_listener', TranslationListener::class)
            ->args([
                service('flasher.translator')->nullOnInvalid(),
            ])
            ->tag('kernel.event_listener')

        ->set('flasher.preset_listener', ApplyPresetListener::class)
            ->args([
                abstract_arg('config.presets'),
            ])
            ->tag('kernel.event_listener')

        ->set('flasher.notification_factory', NotificationFactory::class)
            ->args([service('flasher.storage_manager')])

        ->set('flasher.request_extension', RequestExtension::class)
            ->args([
                service('flasher'),
                abstract_arg('config.flash_bag'),
            ])

        ->set('flasher.response_extension', ResponseExtension::class)
            ->args([service('flasher')])

        ->set('flasher.config', Config::class)
            ->args([abstract_arg('config')])

        ->set('flasher.storage', Storage::class)
            ->args([service('flasher.storage_bag')])

        ->set('flasher.storage_bag', SessionBag::class)
            ->args([service('request_stack')])

        ->set('flasher.event_dispatcher', EventDispatcher::class)

        ->set('flasher.filter_factory', FilterFactory::class)

        ->set('flasher.storage_manager', StorageManager::class)
            ->args([
                service('flasher.storage'),
                service('flasher.event_dispatcher'),
                service('flasher.filter_factory'),
                abstract_arg('config.filter'),
            ])

        ->set('flasher.resource_manager', ResourceManager::class)
            ->args([service('flasher.config')])

        ->set('flasher.response_manager', ResponseManager::class)
            ->args([
                service('flasher.resource_manager'),
                service('flasher.storage_manager'),
                service('flasher.event_dispatcher'),
            ])

        ->set('flasher.translator', Translator::class)
            ->args([service('translator')->nullOnInvalid()])
    ;
};
