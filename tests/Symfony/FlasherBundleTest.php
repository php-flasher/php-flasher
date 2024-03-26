<?php

declare(strict_types=1);

namespace Flasher\Tests\Symfony;

use Flasher\Prime\Plugin\FlasherPlugin;
use Flasher\Symfony\FlasherBundle;
use Flasher\Tests\Symfony\Fixtures\FlasherKernel;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class FlasherBundleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherBundle $flasherBundle;

    protected function setUp(): void
    {
        $this->flasherBundle = new FlasherBundle();
    }

    public function testFlasherIntegration(): void
    {
        $kernel = new FlasherKernel();
        $kernel->boot();

        $container = $kernel->getContainer();

        $this->assertTrue($container->has('flasher'));
        $this->assertTrue($container->has('flasher.noty'));
        $this->assertTrue($container->has('flasher.notyf'));
        $this->assertTrue($container->has('flasher.sweetalert'));
        $this->assertTrue($container->has('flasher.toastr'));

        $this->assertInstanceOf(\Flasher\Prime\FlasherInterface::class, $container->get('flasher'));
        $this->assertInstanceOf(\Flasher\Noty\Prime\NotyInterface::class, $container->get('flasher.noty'));
        $this->assertInstanceOf(\Flasher\Notyf\Prime\NotyfInterface::class, $container->get('flasher.notyf'));
        $this->assertInstanceOf(\Flasher\SweetAlert\Prime\SweetAlertInterface::class, $container->get('flasher.sweetalert'));
        $this->assertInstanceOf(\Flasher\Toastr\Prime\ToastrInterface::class, $container->get('flasher.toastr'));
    }

    public function testBuild(): void
    {
        $containerBuilder = \Mockery::mock(ContainerBuilder::class);
        $containerBuilder->expects('addCompilerPass')
            ->twice()
            ->andReturns($containerBuilder);

        $this->flasherBundle->build($containerBuilder);
    }

    public function testGetContainerExtension(): void
    {
        $containerExtension = $this->flasherBundle->getContainerExtension();

        $this->assertInstanceOf(ExtensionInterface::class, $containerExtension);
    }

    public function testCreatePlugin(): void
    {
        $flasherPlugin = $this->flasherBundle->createPlugin();

        $this->assertInstanceOf(FlasherPlugin::class, $flasherPlugin);
    }
}
