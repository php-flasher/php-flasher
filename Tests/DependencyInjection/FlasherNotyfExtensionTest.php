<?php

namespace Flasher\Notyf\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherBundle;
use Flasher\Notyf\Symfony\DependencyInjection\FlasherNotyfExtension;
use Flasher\Notyf\Symfony\FlasherNotyfBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherNotyfExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->loadFromExtension('flasher_notyf', array());
        $container->compile();

        $this->assertTrue($container->has('flasher.notyf'));
    }

    public function testCreateInstanceOfNotyfAdapter()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher');
        $container->loadFromExtension('flasher_notyf');
        $container->compile();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(1, $calls);
        $this->assertSame('addFactory', $calls[0][0]);
        $this->assertSame('notyf', $calls[0][1][0]);
        $this->assertSame('flasher.notyf', (string) $calls[0][1][1]);
    }

    public function testConfigurationInjectedIntoFlasherConfig()
    {
        $container = $this->getContainer();
        $config = $container->get('flasher.config');
        $this->assertNotEmpty($config->get('adapters.notyf'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherNotyfExtension());
        $adapterBundle = new FlasherNotyfBundle();
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
