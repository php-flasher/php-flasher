<?php

namespace Flasher\Symfony\Tests\DependencyInjection;

use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlasherExtensionTest extends TestCase
{
    public function testContainerContainFlasherServices()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('flasher', array());
        $container->compile();

        $this->assertTrue($container->has('flasher'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();

        $extension = new FlasherExtension();
        $container->registerExtension($extension);

        $bundle = new FlasherBundle();
        $bundle->build($container);

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
