<?php

namespace Flasher\SweetAlert\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherBundle;
use Flasher\SweetAlert\Symfony\DependencyInjection\FlasherSweetAlertExtension;
use Flasher\SweetAlert\Symfony\FlasherSweetAlertBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherSweetAlertExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->loadFromExtension('flasher_sweet_alert', array());
        $container->compile();

        $this->assertTrue($container->has('flasher.sweet_alert'));
    }

    public function testCreateInstanceOfSweetAlertAdapter()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher');
        $container->loadFromExtension('flasher_sweet_alert');
        $container->compile();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(2, $calls);

        $this->assertSame('addFactory', $calls[0][0]);
        $this->assertSame('template', $calls[0][1][0]);
        $this->assertSame('flasher.notification_factory', (string) $calls[0][1][1]);

        $this->assertSame('addFactory', $calls[1][0]);
        $this->assertSame('sweet_alert', $calls[1][1][0]);
        $this->assertSame('flasher.sweet_alert', (string) $calls[1][1][1]);
    }

    public function testConfigurationInjectedIntoFlasherConfig()
    {
        $container = $this->getContainer();
        $config = $container->get('flasher.config');
        $this->assertNotEmpty($config->get('adapters.sweet_alert'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherSweetAlertExtension());
        $adapterBundle = new FlasherSweetAlertBundle();
        $adapterBundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());

        return $container;
    }

    private function getContainer()
    {
        $container = $this->getRawContainer();
        $container->compile();

        return $container;
    }
}
