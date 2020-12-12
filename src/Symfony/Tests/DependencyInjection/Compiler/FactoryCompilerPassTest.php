<?php

namespace Flasher\Symfony\Tests\DependencyInjection\Compiler;

use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherBundle;
use Flasher\Symfony\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class FactoryCompilerPassTest extends TestCase
{
    public function testProcess()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->hasDefinition('test_flasher'));

        $flasher = $container->getDefinition('test_flasher');
        $this->assertTrue($flasher->hasTag('flasher.factory'));

        $manager = $container->getDefinition('flasher');
        $calls = $manager->getMethodCalls();

        $this->assertCount(1, $calls);
        $this->assertEquals('addFactory', $calls[0][0]);
        $this->assertEquals('test_flasher', $calls[0][1][0]);
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        $flasher = new Definition('test_flasher');
        $flasher->addTag('flasher.factory', array('alias' => 'test_flasher'));
        $container->setDefinition('test_flasher', $flasher);

        $extension = new FlasherExtension();
        $container->registerExtension($extension);

        $bundle = new FlasherBundle();
        $bundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());

        $container->loadFromExtension('flasher', array());
        $container->compile();

        return $container;
    }
}
