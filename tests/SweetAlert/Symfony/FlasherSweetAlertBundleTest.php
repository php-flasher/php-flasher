<?php

declare(strict_types=1);

namespace Flasher\Tests\SweetAlert\Symfony;

use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\SweetAlert\Symfony\FlasherSweetAlertBundle;
use Flasher\Symfony\Support\PluginBundle;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class FlasherSweetAlertBundleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherSweetAlertBundle $flasherSweetAlertBundle;

    protected function setUp(): void
    {
        $this->flasherSweetAlertBundle = new FlasherSweetAlertBundle();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(PluginBundle::class, $this->flasherSweetAlertBundle);
    }

    public function testCreatePlugin(): void
    {
        $this->assertInstanceOf(SweetAlertPlugin::class, $this->flasherSweetAlertBundle->createPlugin());
    }

    public function testGetConfigurationFileReturnsExpectedPath(): void
    {
        $expectedPath = $this->flasherSweetAlertBundle->getPath().'/Resources/config/config.yaml';

        $this->assertSame($expectedPath, $this->flasherSweetAlertBundle->getConfigurationFile());
    }
}
