<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Noty\Symfony\FlasherNotySymfonyBundle;
use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Notyf\Symfony\FlasherNotyfSymfonyBundle;
use Flasher\Pnotify\Prime\PnotifyPlugin;
use Flasher\Pnotify\Symfony\FlasherPnotifySymfonyBundle;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\SweetAlert\Symfony\FlasherSweetAlertSymfonyBundle;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherSymfonyBundle;
use Flasher\Symfony\Support\Extension;
use Flasher\Tests\Prime\TestCase;
use Flasher\Toastr\Prime\ToastrPlugin;
use Flasher\Toastr\Symfony\FlasherToastrSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->has('flasher'));
        $this->assertTrue($container->has('flasher.noty'));
        $this->assertTrue($container->has('flasher.notyf'));
        $this->assertTrue($container->has('flasher.pnotify'));
        $this->assertTrue($container->has('flasher.sweetalert'));
        $this->assertTrue($container->has('flasher.toastr'));
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new FlasherExtension());

        $plugins = array(
            new NotyPlugin(),
            new NotyfPlugin(),
            new PnotifyPlugin(),
            new SweetAlertPlugin(),
            new ToastrPlugin(),
        );

        foreach ($plugins as $plugin) {
            $container->registerExtension(new Extension($plugin));
        }

        $bundles = array(
            new FlasherSymfonyBundle(),
            new FlasherNotySymfonyBundle(),
            new FlasherNotyfSymfonyBundle(),
            new FlasherPnotifySymfonyBundle(),
            new FlasherSweetAlertSymfonyBundle(),
            new FlasherToastrSymfonyBundle(),
        );

        foreach ($bundles as $bundle) {
            $bundle->build($container);
        }

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());

        $extensions = array(
            'flasher',
            'flasher_noty',
            'flasher_notyf',
            'flasher_pnotify',
            'flasher_sweetalert',
            'flasher_toastr',
        );

        foreach ($extensions as $extension) {
            $container->loadFromExtension($extension, array());
        }

        $container->compile();

        return $container;
    }
}
