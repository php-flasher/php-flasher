<?php

namespace Flasher\Tests\Noty\Symfony\DependencyInjection;

use Flasher\Noty\Symfony\DependencyInjection\FlasherNotyExtension;
use Flasher\Noty\Symfony\FlasherNotySymfonyBundle;
use Flasher\Tests\Prime\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherNotyExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->has('flasher.noty'));
    }

    public function testCreateInstanceOfNotyAdapter()
    {
        $container = $this->getContainer();

        $flasher = $container->getDefinition('flasher');
        $calls = $flasher->getMethodCalls();

        $this->assertCount(2, $calls);

        $this->assertEquals('addFactory', $calls[0][0]);
        $this->assertEquals('template', $calls[0][1][0]);
        $this->assertEquals('flasher.template', (string) $calls[0][1][1]);

        $this->assertEquals('addFactory', $calls[1][0]);
        $this->assertEquals('noty', $calls[1][1][0]);
        $this->assertEquals('flasher.noty', (string) $calls[1][1][1]);
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new FlasherExtension());
        $flasherBundle = new FlasherSymfonyBundle();
        $flasherBundle->build($container);

        $container->registerExtension(new FlasherNotyExtension());
        $adapterBundle = new FlasherNotySymfonyBundle();
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
        $container->loadFromExtension('flasher_noty', array());
        $container->compile();

        return $container;
    }
}
