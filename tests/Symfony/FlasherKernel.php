<?php

namespace Flasher\Tests\Symfony;

use Flasher\Noty\Symfony\FlasherNotySymfonyBundle;
use Flasher\Notyf\Symfony\FlasherNotyfSymfonyBundle;
use Flasher\Pnotify\Symfony\FlasherPnotifySymfonyBundle;
use Flasher\SweetAlert\Symfony\FlasherSweetAlertSymfonyBundle;
use Flasher\Symfony\Bridge\Bridge;
use Flasher\Symfony\FlasherSymfonyBundle;
use Flasher\Toastr\Symfony\FlasherToastrSymfonyBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

abstract class AbstractFlasherKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function doRegisterBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new FlasherSymfonyBundle(),
            new FlasherNotySymfonyBundle(),
            new FlasherNotyfSymfonyBundle(),
            new FlasherPnotifySymfonyBundle(),
            new FlasherSweetAlertSymfonyBundle(),
            new FlasherToastrSymfonyBundle(),
        ];
    }

    public function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $framework = [
            'secret' => 'foo',
            'test' => true,
            'session' => ['handler_id' => null, 'storage_factory_id' => 'session.storage.factory.mock_file'],
            'router' => ['resource' => 'kernel:loadRoutes', 'type' => 'service'],
        ];

        if (Bridge::versionCompare('6.0', '<')) {
            unset($framework['session']);
            $framework['session']['storage_id'] = 'session.storage.filesystem';
        }

        if (Bridge::versionCompare('3', '<')) {
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

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $that = $this;
        $loader->load(function (ContainerBuilder $container) use ($loader, $that) {
            if ($that instanceof EventSubscriberInterface) {
                $class = $that::class;
                $container->register('kernel', $class)
                    ->setSynthetic(true)
                    ->setPublic(true)
                    ->addTag('kernel.event_subscriber')
                ;
            }

            $that->configureContainer($container, $loader);

            $container->addObjectResource($that);
        });
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
    }
}

if (Bridge::versionCompare('6.0', '>=')) {
    eval('
        namespace Flasher\Tests\Symfony;

        class FlasherKernel extends AbstractFlasherKernel
        {
            public function registerBundles(): iterable
            {
                return $this->doRegisterBundles();
            }

            public function getCacheDir(): string
            {
                return $this->doGetLogDir();
            }

            public function getLogDir(): string
            {
                return $this->doGetLogDir();
            }

            public function getProjectDir(): string
            {
                return \dirname(__DIR__);
            }
        }
    ');
} else {
    class FlasherKernel extends AbstractFlasherKernel
    {
        public function registerBundles()
        {
            return $this->doRegisterBundles();
        }

        public function getCacheDir()
        {
            return $this->doGetLogDir();
        }

        public function getLogDir()
        {
            return $this->doGetLogDir();
        }
    }
}
