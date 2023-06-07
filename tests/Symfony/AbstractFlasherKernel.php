<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

abstract class AbstractFlasherKernel extends \Symfony\Component\HttpKernel\Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function doRegisterBundles()
    {
        return [new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(), new \Symfony\Bundle\TwigBundle\TwigBundle(), new \Flasher\Symfony\FlasherBundle(), new \Flasher\Noty\Symfony\FlasherNotySymfonyBundle(), new \Flasher\Notyf\Symfony\FlasherNotyfSymfonyBundle(), new \Flasher\Pnotify\Symfony\FlasherPnotifyBundle(), new \Flasher\SweetAlert\Symfony\FlasherSweetAlertBundle(), new \Flasher\Toastr\Symfony\FlasherToastrBundle()];
    }

    public function configureContainer(\Symfony\Component\DependencyInjection\ContainerBuilder $container, \Symfony\Component\Config\Loader\LoaderInterface $loader): void
    {
        $framework = ['secret' => 'foo', 'test' => true, 'session' => ['handler_id' => null, 'storage_factory_id' => 'session.storage.factory.mock_file'], 'router' => ['resource' => 'kernel:loadRoutes', 'type' => 'service']];
        if (\Flasher\Symfony\Bridge\Bridge::versionCompare('6.0', '<')) {
            unset($framework['session']);
            $framework['session']['storage_id'] = 'session.storage.filesystem';
        }

        if (\Flasher\Symfony\Bridge\Bridge::versionCompare('3', '<')) {
            $framework['templating']['engines'] = 'twig';
        }

        $container->loadFromExtension('framework', $framework);
        $twig = ['debug' => true, 'strict_variables' => true];
        $container->loadFromExtension('twig', $twig);
    }

    public function doGetCacheDir()
    {
        return sys_get_temp_dir().'/cache'.spl_object_hash($this);
    }

    public function doGetLogDir()
    {
        return sys_get_temp_dir().'/logs'.spl_object_hash($this);
    }

    public function registerContainerConfiguration(\Symfony\Component\Config\Loader\LoaderInterface $loader): void
    {
        $that = $this;
        $loader->load(static function (\Symfony\Component\DependencyInjection\ContainerBuilder $container) use ($loader, $that): void {
            if ($that instanceof \Symfony\Component\EventDispatcher\EventSubscriberInterface) {
                $class = $that::class;
                $container->register('kernel', $class)->setSynthetic(true)->setPublic(true)->addTag('kernel.event_subscriber');
            }

            $that->configureContainer($container, $loader);
            $container->addObjectResource($that);
        });
    }

    protected function configureRoutes(\Symfony\Component\Routing\RouteCollectionBuilder $routes)
    {
    }
}
