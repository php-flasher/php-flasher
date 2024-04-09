<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\Fixtures;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

final class FlasherKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Flasher\Symfony\FlasherBundle(),
            new \Flasher\Noty\Symfony\FlasherNotyBundle(),
            new \Flasher\Notyf\Symfony\FlasherNotyfBundle(),
            new \Flasher\SweetAlert\Symfony\FlasherSweetAlertBundle(),
            new \Flasher\Toastr\Symfony\FlasherToastrBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container): void {
            $container->register('kernel', static::class)
                ->setPublic(true);

            $this->configureContainer($container);
            $container->addObjectResource($this);
        });
    }

    public function configureContainer(ContainerBuilder $container): void
    {
        $container->loadFromExtension('framework', [
            'secret' => 'foo',
            'test' => true,
            'session' => [
                'handler_id' => null,
                'storage_factory_id' => 'session.storage.factory.mock_file',
            ],
        ]);

        $container->loadFromExtension('twig', [
            'debug' => true,
            'strict_variables' => true,
        ]);
    }

    public function getProjectDir(): string
    {
        return __DIR__.'/project';
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/cache'.spl_object_hash($this);
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/logs'.spl_object_hash($this);
    }
}
