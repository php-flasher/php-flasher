<?php

namespace Flasher\Toastr\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherBundle;
use Flasher\Toastr\Symfony\DependencyInjection\FlasherToastrExtension;
use Flasher\Toastr\Symfony\FlasherToastrBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherToastrExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->loadFromExtension('flasher_toastr', array());
        $container->compile();

        $this->assertTrue($container->has('flasher.toastr'));
    }

    public function testCreateInstanceOfToastrAdapter()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher');
        $container->loadFromExtension('flasher_toastr');
        $container->compile();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(1, $calls);
        $this->assertSame('addFactory', $calls[0][0]);
        $this->assertSame('toastr', $calls[0][1][0]);
        $this->assertSame('flasher.toastr', (string) $calls[0][1][1]);
    }

    public function testConfigurationInjectedIntoFlasherConfig()
    {
        $container = $this->getContainer();
        $config = $container->get('flasher.config');
        $this->assertNotEmpty($config->get('adapters.toastr'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherToastrExtension());
        $adapterBundle = new FlasherToastrBundle();
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
