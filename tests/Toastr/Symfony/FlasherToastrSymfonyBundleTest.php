<?php

declare(strict_types=1);

namespace Flasher\Tests\Toastr\Symfony;

use Flasher\Symfony\Support\PluginBundle;
use Flasher\Toastr\Prime\ToastrPlugin;
use Flasher\Toastr\Symfony\FlasherToastrSymfonyBundle;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class FlasherToastrSymfonyBundleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherToastrSymfonyBundle $flasherToastrBundle;

    protected function setUp(): void
    {
        parent::setUp();

        $this->flasherToastrBundle = new FlasherToastrSymfonyBundle();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(PluginBundle::class, $this->flasherToastrBundle);
    }

    public function testCreatePlugin(): void
    {
        $this->assertInstanceOf(ToastrPlugin::class, $this->flasherToastrBundle->createPlugin());
    }

    public function testGetConfigurationFileReturnsExpectedPath(): void
    {
        $expectedPath = $this->flasherToastrBundle->getPath().'/Resources/config/config.yaml';

        $this->assertSame($expectedPath, $this->flasherToastrBundle->getConfigurationFile());
    }
}
