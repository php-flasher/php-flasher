<?php

declare(strict_types=1);

namespace Flasher\Tests\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Noty\Symfony\FlasherNotyBundle;
use Flasher\Symfony\Support\PluginBundle;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class FlasherNotyBundleTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherNotyBundle $flasherNotyBundle;

    protected function setUp(): void
    {
        $this->flasherNotyBundle = new FlasherNotyBundle();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(PluginBundle::class, $this->flasherNotyBundle);
    }

    public function testCreatePlugin(): void
    {
        $this->assertInstanceOf(NotyPlugin::class, $this->flasherNotyBundle->createPlugin());
    }

    public function testGetConfigurationFileReturnsExpectedPath(): void
    {
        $expectedPath = $this->flasherNotyBundle->getPath().'/Resources/config/config.yaml';

        $this->assertSame($expectedPath, $this->flasherNotyBundle->getConfigurationFile());
    }
}
