<?php

use Symfony\Component\DependencyInjection\Reference;
use Flasher\Symfony\Bridge\Bridge;

$container
    ->register('flasher.config', 'Flasher\Prime\Config\Config')
    ->addArgument(array());

$container
    ->register('flasher.storage', 'Flasher\Symfony\Storage\Storage')
    ->addArgument(null);

$container
    ->register('flasher.event_dispatcher', 'Flasher\Prime\EventDispatcher\EventDispatcher');

$container
    ->register('flasher.storage_manager', 'Flasher\Prime\Storage\StorageManager')
    ->addArgument(new Reference('flasher.storage'))
    ->addArgument(new Reference('flasher.event_dispatcher'));

$container
    ->register('flasher.template', 'Flasher\Prime\Factory\TemplateFactory')
    ->addArgument( new Reference('flasher.storage_manager'))
    ->addTag('flasher.factory', array('alias' => 'template'));

$container
    ->register('flasher.filter', 'Flasher\Prime\Filter\Filter');

$container
    ->register('flasher.event_listener.filter_listener', 'Flasher\Prime\EventDispatcher\EventListener\FilterListener')
    ->addArgument(new Reference('flasher.filter'))
    ->addTag('flasher.event_subscriber');

$container
    ->register('flasher.event_listener.post_flush_listener', 'Flasher\Prime\EventDispatcher\EventListener\RemoveListener')
    ->addTag('flasher.event_subscriber');

$container
    ->register('flasher.event_listener.stamps_listener', 'Flasher\Prime\EventDispatcher\EventListener\StampsListener')
    ->addTag('flasher.event_subscriber');

$container
    ->register('flasher.twig.extension', 'Flasher\Symfony\Twig\FlasherTwigExtension')
    ->addArgument(new Reference('flasher.response_manager'))
    ->addTag('twig.extension', array());

$container
    ->register('flasher.resource_manager', 'Flasher\Prime\Response\Resource\ResourceManager')
    ->addArgument(new Reference('flasher.config'))
    ->addArgument(new Reference('flasher.template_engine'));

$container
    ->register('flasher.response_manager', 'Flasher\Prime\Response\ResponseManager')
    ->addArgument(new Reference('flasher.storage_manager'))
    ->addArgument(new Reference('flasher.event_dispatcher'))
    ->addArgument(new Reference('flasher.resource_manager'));

$container
    ->register('flasher.presenter.html', 'Flasher\Prime\Response\Presenter\HtmlPresenter')
    ->addTag('flasher.presenter', array('alias' => 'html'));

$container
    ->register('flasher.presenter.array', 'Flasher\Prime\Response\Presenter\ArrayPresenter')
    ->addTag('flasher.presenter', array('alias' => 'array'));

$container
    ->register('flasher.session_listener', 'Flasher\Symfony\EventListener\SessionListener')
    ->addArgument(new Reference('flasher.config'))
    ->addArgument(new Reference('flasher'))
    ->addArgument(new Reference('flasher.response_manager'))
    ->addTag('kernel.event_listener', array('event' => 'kernel.response'));

$container
    ->register('flasher.template_engine', 'Flasher\Symfony\Template\TwigEngine')
    ->addArgument(new Reference('twig'));

$container
    ->register('flasher', 'Flasher\Prime\Flasher')
    ->addArgument(new Reference('flasher.config'))
    ->addArgument(new Reference('flasher.response_manager'));

if (Bridge::canLoadAliases()) {
    $container->setAlias('Flasher\Prime\Config\Config', 'flasher.config');
    $container->setAlias('Flasher\Prime\Config\ConfigInterface', 'flasher.config');
    $container->setAlias('Flasher\Prime\EventDispatcher\EventDispatcher', 'flasher.event_dispatcher');
    $container->setAlias('Flasher\Prime\EventDispatcher\EventDispatcherInterface', 'flasher.event_dispatcher');
    $container->setAlias('Flasher\Prime\Factory\TemplateFactory', 'flasher.template');
    $container->setAlias('Flasher\Prime\Factory\NotificationFactory', 'flasher.template');
    $container->setAlias('Flasher\Prime\Factory\NotificationFactoryInterface', 'flasher.template');
    $container->setAlias('flasher.notification_factory', 'flasher.template');
    $container->setAlias('Flasher\Prime\Filter\Filter', 'flasher.filter');
    $container->setAlias('Flasher\Prime\Filter\FilterInterface', 'flasher.filter');
    $container->setAlias('Flasher\Prime\Flasher', 'flasher');
    $container->setAlias('Flasher\Prime\FlasherInterface', 'flasher');
    $container->setAlias('Flasher\Prime\Response\ResponseManagerInterface', 'flasher.response_manager');
    $container->setAlias('Flasher\Prime\Storage\StorageInterface', 'flasher.storage');
    $container->setAlias('Flasher\Prime\Storage\StorageManager', 'flasher.storage_manager');
    $container->setAlias('Flasher\Prime\Storage\StorageManagerInterface', 'flasher.storage_manager');
    $container->setAlias('Flasher\Prime\Template\EngineInterface', 'flasher.template_engine');
    $container->setAlias('Flasher\Symfony\Storage\Storage', 'flasher.storage');
    $container->setAlias('Flasher\Symfony\Template\TwigEngine', 'flasher.template_engine');
}
