<?php

namespace Flasher\Tests\Notyf\Symfony\DependencyInjection;

use Flasher\Notyf\Symfony\DependencyInjection\FlasherNotyfExtension;
use Flasher\Notyf\Symfony\FlasherNotyfSymfonyBundle;
use Flasher\Tests\Prime\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherNotyfExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->has('flasher.notyf'));
    }

    public function testCreateInstanceOfNotyfAdapter()
    {
        $container = $this->getContainer();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(2, $calls);

        $this->assertEquals('addFactory', $calls[0][0]);
        $this->assertEquals('template', $calls[0][1][0]);
        $this->assertEquals('flasher.template', (string) $calls[0][1][1]);

        $this->assertEquals('addFactory', $calls[1][0]);
        $this->assertEquals('notyf', $calls[1][1][0]);
        $this->assertEquals('flasher.notyf', (string) $calls[1][1][1]);
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherSymfonyBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherNotyfExtension());
        $adapterBundle = new FlasherNotyfSymfonyBundle();
        $adapterBundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());

        return $container;
    }

    private function getContainer()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->loadFromExtension('flasher_notyf', array());
        $container->compile();

        return $container;
    }
}
