<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\DependencyInjection\Compiler;

use Flasher\Symfony\DependencyInjection\Compiler\EventListenerCompilerPass;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class EventListenerCompilerPassTest
 * This class test the process method in the EventListenerCompilerPass class.
 */
final class EventListenerCompilerPassTest extends MockeryTestCase
{
    private EventListenerCompilerPass $compilerPass;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->compilerPass = new EventListenerCompilerPass();
        $this->container = new ContainerBuilder();
    }

    /**
     * Test process method with services tagged as 'flasher.event_listener'.
     */
    public function testProcessWithTaggedServices(): void
    {
        $definition = new Definition();
        $this->container->setDefinition('flasher.event_dispatcher', $definition);

        $this->container->register('service1')->addTag('flasher.event_listener');
        $this->container->register('service2')->addTag('flasher.event_listener');

        $this->compilerPass->process($this->container);

        $calls = $definition->getMethodCalls();
        $this->assertCount(2, $calls);
        $this->assertSame('addListener', $calls[0][0]);
        $this->assertInstanceOf(Reference::class, $calls[0][1][0]);
        $this->assertSame('addListener', $calls[1][0]);
        $this->assertInstanceOf(Reference::class, $calls[1][1][0]);
    }

    /**
     * Test process method with no services tagged as 'flasher.event_listener'.
     */
    public function testProcessWithNoTaggedServices(): void
    {
        $definition = new Definition();
        $this->container->setDefinition('flasher.event_dispatcher', $definition);

        $this->compilerPass->process($this->container);

        $this->assertCount(0, $definition->getMethodCalls(), 'No method calls should be made when no tagged services exist.');
    }
}
