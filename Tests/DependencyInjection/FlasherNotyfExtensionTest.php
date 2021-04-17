<?php

namespace Flasher\Notyf\Symfony\Tests\DependencyInjection;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherSymfonyBundle;
use Flasher\Notyf\Symfony\DependencyInjection\FlasherNotyfExtension;
use Flasher\Notyf\Symfony\FlasherNotyfSymfonyBundle;
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

        $this->assertSame('addFactory', $calls[0][0]);
        $this->assertSame('template', $calls[0][1][0]);
        $this->assertSame('flasher.notification_factory', (string) $calls[0][1][1]);

        $this->assertSame('addFactory', $calls[1][0]);
        $this->assertSame('notyf', $calls[1][1][0]);
        $this->assertSame('flasher.notyf', (string) $calls[1][1][1]);
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
