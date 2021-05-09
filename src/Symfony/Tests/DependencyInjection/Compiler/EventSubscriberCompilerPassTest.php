<?php

namespace Flasher\Symfony\Tests\DependencyInjection\Compiler;

use Flasher\Prime\Tests\TestCase;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Flasher\Symfony\FlasherSymfonyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class EventSubscriberCompilerPassTest extends TestCase
{
    public function testProcess()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->hasDefinition('test_subscriber'));

        $flasher = $container->getDefinition('test_subscriber');
        $this->assertTrue($flasher->hasTag('flasher.event_subscriber'));

        $manager = $container->getDefinition('flasher.event_dispatcher');
        $calls = $manager->getMethodCalls();

        $this->assertCount(4, $calls);

        $this->assertSame('addSubscriber', $calls[0][0]);
        $this->assertSame('test_subscriber', $calls[0][1][0]);

        $this->assertSame('addSubscriber', $calls[1][0]);
        $this->assertSame('flasher.event_listener.filter_listener', $calls[1][1][0]);

        $this->assertSame('addSubscriber', $calls[2][0]);
        $this->assertSame('flasher.event_listener.post_flush_listener', $calls[2][1][0]);

        $this->assertSame('addSubscriber', $calls[3][0]);
        $this->assertSame('flasher.event_listener.stamps_listener', $calls[3][1][0]);
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        $flasher = new Definition('test_subscriber');
        $flasher->addTag('flasher.event_subscriber');
        $container->setDefinition('test_subscriber', $flasher);

        $extension = new FlasherExtension();
        $container->registerExtension($extension);

        $bundle = new FlasherSymfonyBundle();
        $bundle->build($container);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->getCompilerPassConfig()->setAfterRemovingPasses(array());

        $container->loadFromExtension('flasher', array());
        $container->compile();

        return $container;
    }
}
