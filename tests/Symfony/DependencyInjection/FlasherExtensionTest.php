<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony\DependencyInjection;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\DependencyInjection\FlasherExtension;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class FlasherExtensionTest extends MockeryTestCase
{
    private ContainerBuilder $container;

    private FlasherExtension $extension;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new FlasherExtension(new FlasherPlugin());

        $this->container->setParameter('kernel.environment', 'test');
        $this->container->setParameter('kernel.build_dir', __DIR__.'/../Fixtures/project/build');
        $this->container->setParameter('kernel.project_dir', __DIR__.'/../Fixtures/project');
    }

    public function testConfigurationIsLoadedAndParametersAreSet(): void
    {
        $config = [
            'default' => 'flasher',
            'main_script' => 'assets/flasher.js',
            'inject_assets' => true,
        ];

        $this->extension->load([$config], $this->container);

        $this->assertSame('flasher', $this->container->getParameter('flasher.default'));
        $this->assertTrue($this->container->getParameter('flasher.inject_assets'));
    }

    public function testServiceDefinitionsAreRegistered(): void
    {
        $config = [
            'default' => 'flasher',
            'main_script' => 'assets/flasher.js',
            'inject_assets' => true,
        ];

        $this->extension->load([$config], $this->container);
        $this->extension->process($this->container);

        // Assert core services are registered
        $this->assertTrue($this->container->has('flasher'));
        $this->assertTrue($this->container->has('flasher.asset_manager'));
        $this->assertTrue($this->container->has('flasher.event_dispatcher'));
    }

    public function testAutoConfigurationAppliesTagsCorrectly(): void
    {
        $config = [
            'inject_assets' => true,
        ];

        $this->extension->load([$config], $this->container);
        $this->extension->process($this->container);

        $this->container->register('dummy.event_listener', \stdClass::class)
            ->addTag('flasher.event_listener');

        $this->extension->process($this->container);

        $tags = $this->container->getDefinition('dummy.event_listener')->getTags();
        $this->assertArrayHasKey('flasher.event_listener', $tags);
    }

    public function testConditionalServiceRemoval(): void
    {
        $config = [
            'default' => 'flasher',
            'inject_assets' => false, // This should lead to the removal of 'flasher.flasher_listener'.
            'flash_bag' => false, // This should affect session services.
        ];

        $this->extension->load([$config], $this->container);
        $this->extension->process($this->container);

        // Assert that 'flasher.flasher_listener' is removed.
        $this->assertFalse($this->container->has('flasher.flasher_listener'));
    }

    public function testPluginNameAliasIsSetCorrectly(): void
    {
        $alias = $this->extension->getAlias();
        $this->assertSame('flasher', $alias);
    }
}
