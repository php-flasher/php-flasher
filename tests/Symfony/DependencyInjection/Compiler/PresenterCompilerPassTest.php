<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\DependencyInjection\Compiler;

use Flasher\Symfony\DependencyInjection\Compiler\PresenterCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class PresenterCompilerPassTest extends TestCase
{
    private PresenterCompilerPass $compilerPass;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->compilerPass = new PresenterCompilerPass();
        $this->container = new ContainerBuilder();
    }

    public function testProcessWithTaggedPresenters(): void
    {
        $definition = new Definition();
        $this->container->setDefinition('flasher.response_manager', $definition);

        // Register two services with the 'flasher.presenter' tag and custom attributes
        $this->container->register('presenter1')->addTag('flasher.presenter', ['alias' => 'presenter1_alias']);
        $this->container->register('presenter2')->addTag('flasher.presenter', ['alias' => 'presenter2_alias']);

        $this->compilerPass->process($this->container);

        $calls = $definition->getMethodCalls();
        $this->assertCount(2, $calls);
        $this->assertSame('addPresenter', $calls[0][0]);
        $this->assertSame('presenter1_alias', $calls[0][1][0]);
        $this->assertInstanceOf(Reference::class, $calls[0][1][1]->getValues()[0]);

        $this->assertSame('addPresenter', $calls[1][0]);
        $this->assertSame('presenter2_alias', $calls[1][1][0]);
        $this->assertInstanceOf(Reference::class, $calls[1][1][1]->getValues()[0]);
    }

    public function testProcessWithNoTaggedPresenters(): void
    {
        $definition = new Definition();
        $this->container->setDefinition('flasher.response_manager', $definition);

        $this->compilerPass->process($this->container);

        $this->assertCount(0, $definition->getMethodCalls(), 'No method calls should be made when no tagged services exist.');
    }
}
