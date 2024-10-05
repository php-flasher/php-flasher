<?php

declare(strict_types=1);

use Flasher\Prime\Asset\AssetManager;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\Flasher;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandler;
use Flasher\Prime\Http\Csp\NonceGenerator;
use Flasher\Prime\Http\RequestExtension;
use Flasher\Prime\Http\ResponseExtension;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\ResponseManager;
use Flasher\Prime\Storage\Filter\FilterFactory;
use Flasher\Prime\Storage\Storage;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Symfony\Command\InstallCommand;
use Flasher\Symfony\Component\FlasherComponent;
use Flasher\Symfony\EventListener\FlasherListener;
use Flasher\Symfony\EventListener\SessionListener;
use Flasher\Symfony\Factory\NotificationFactoryLocator;
use Flasher\Symfony\Profiler\FlasherDataCollector;
use Flasher\Symfony\Storage\SessionBag;
use Flasher\Symfony\Template\TwigTemplateEngine;
use Flasher\Symfony\Translation\Translator;
use Flasher\Symfony\Twig\FlasherTwigExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\inline_service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_locator;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('flasher', Flasher::class)
            ->public()
            ->args([
                param('flasher.default'),
                inline_service(NotificationFactoryLocator::class)
                    ->args([tagged_locator('flasher.factory', indexAttribute: 'alias')]),
                service('flasher.response_manager'),
                service('flasher.storage_manager'),
            ])
            ->alias(FlasherInterface::class, 'flasher')

        ->set('flasher.flasher_listener', FlasherListener::class)
            ->args([
                inline_service(ResponseExtension::class)
                    ->args([
                        service('flasher'),
                        service('flasher.csp_handler'),
                        param('flasher.excluded_paths'),
                    ]),
            ])
            ->tag('kernel.event_subscriber')

        ->set('flasher.twig_extension', FlasherTwigExtension::class)
            ->args([service('flasher')])
            ->tag('twig.extension')

        ->set('flasher.session_listener', SessionListener::class)
            ->args([
                inline_service(RequestExtension::class)
                    ->args([
                        service('flasher'),
                        param('flasher.flash_bag'),
                    ]),
            ])
            ->tag('kernel.event_subscriber')

        ->set('flasher.notification_logger_listener', NotificationLoggerListener::class)
            ->tag('flasher.event_listener')
            ->tag('kernel.reset', ['method' => 'reset'])

        ->set('flasher.translation_listener', TranslationListener::class)
            ->args([service('flasher.translator')->nullOnInvalid()])
            ->tag('flasher.event_listener')

        ->set('flasher.preset_listener', ApplyPresetListener::class)
            ->args([param('flasher.presets')])
            ->tag('flasher.event_listener')

        ->set('flasher.install_command', InstallCommand::class)
            ->args([service('flasher.asset_manager')])
            ->tag('console.command')

        ->set('flasher.flasher_component', FlasherComponent::class)
            ->tag('twig.component', [
                'key' => 'flasher',
                'template' => '@FlasherSymfony/components/flasher.html.twig',
                'attributesVar' => 'attributes',
            ])

        ->set('flasher.notification_factory', NotificationFactory::class)
            ->abstract()
            ->args([service('flasher.storage_manager')])

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
                param('flasher.filter'),
            ])

        ->set('flasher.template_engine', TwigTemplateEngine::class)
            ->args([service('twig')->nullOnInvalid()])

        ->set('flasher.resource_manager', ResourceManager::class)
            ->args([
                service('flasher.template_engine'),
                service('flasher.asset_manager'),
                param('flasher.main_script'),
                param('flasher.plugins'),
            ])

        ->set('flasher.response_manager', ResponseManager::class)
            ->args([
                service('flasher.resource_manager'),
                service('flasher.storage_manager'),
                service('flasher.event_dispatcher'),
            ])

        ->set('flasher.translator', Translator::class)
            ->args([service('translator')->nullOnInvalid()])

        ->set('flasher.csp_handler', ContentSecurityPolicyHandler::class)
            ->args([inline_service(NonceGenerator::class)])

        ->set('flasher.asset_manager', AssetManager::class)
            ->args([
                param('flasher.public_dir'),
                param('flasher.json_manifest_path'),
            ])

        ->set('flasher.data_collector', FlasherDataCollector::class)
            ->args([
                service('flasher.notification_logger_listener'),
                param('flasher'),
            ])
            ->tag('data_collector', ['id' => 'flasher', 'template' => '@FlasherSymfony/profiler/flasher.html.twig', 'priority' => 0])
    ;
};
