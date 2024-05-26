<?php

declare(strict_types=1);

namespace Flasher\Tests\SweetAlert\Symfony;

use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\SweetAlert\Symfony\FlasherSweetAlertSymfonyBundle;
use Flasher\Symfony\Support\PluginBundle;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class FlasherSweetAlertSymfonyBundleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherSweetAlertSymfonyBundle $flasherSweetAlertBundle;

    protected function setUp(): void
    {
        parent::setUp();

        $this->flasherSweetAlertBundle = new FlasherSweetAlertSymfonyBundle();
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
