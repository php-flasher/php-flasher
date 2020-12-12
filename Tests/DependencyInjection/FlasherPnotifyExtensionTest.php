<?php

namespace Flasher\Pnotify\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherBundle;
use Flasher\Pnotify\Symfony\DependencyInjection\FlasherPnotifyExtension;
use Flasher\Pnotify\Symfony\FlasherPnotifyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherPnotifyExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->loadFromExtension('flasher_pnotify', array());
        $container->compile();

        $this->assertTrue($container->has('flasher.pnotify'));
    }

    public function testCreateInstanceOfPnotifyAdapter()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher');
        $container->loadFromExtension('flasher_pnotify');
        $container->compile();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(1, $calls);
        $this->assertSame('addFactory', $calls[0][0]);
        $this->assertSame('pnotify', $calls[0][1][0]);
        $this->assertSame('flasher.pnotify', (string) $calls[0][1][1]);
    }

    public function testConfigurationInjectedIntoFlasherConfig()
    {
        $container = $this->getContainer();
        $config = $container->get('flasher.config');
        $this->assertNotEmpty($config->get('adapters.pnotify'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherPnotifyExtension());
        $adapterBundle = new FlasherPnotifyBundle();
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
