<?php

declare(strict_types=1);

namespace Flasher\Tests\Noty\Prime;

use Flasher\Noty\Prime\Noty;
use Flasher\Noty\Prime\NotyInterface;
use Flasher\Noty\Prime\NotyPlugin;
use PHPUnit\Framework\TestCase;

final class NotyPluginTest extends TestCase
{
    private NotyPlugin $notyPlugin;

    protected function setUp(): void
    {
        $this->notyPlugin = new NotyPlugin();
    }

    public function testGetAlias(): void
    {
        $this->assertSame('noty', $this->notyPlugin->getAlias());
    }

    public function testGetFactory(): void
    {
        $this->assertSame(Noty::class, $this->notyPlugin->getFactory());
    }

    public function testGetServiceAliases(): void
    {
        $this->assertSame(NotyInterface::class, $this->notyPlugin->getServiceAliases());
    }

    public function testGetScripts(): void
    {
        $this->assertSame([
            '/vendor/flasher/noty.min.js',
            '/vendor/flasher/flasher-noty.min.js',
        ], $this->notyPlugin->getScripts());
    }

    public function testGetStyles(): void
    {
        $this->assertSame([
            '/vendor/flasher/noty.css',
            '/vendor/flasher/mint.css',
        ], $this->notyPlugin->getStyles());
    }

    public function testGetName(): void
    {
        $this->assertSame('flasher_noty', $this->notyPlugin->getName());
    }

    public function testGetServiceId(): void
    {
        $this->assertSame('flasher.noty', $this->notyPlugin->getServiceId());
    }

    public function testNormalizeConfig(): void
    {
        $expected = [
            'scripts' => [
                '/vendor/flasher/noty.min.js',
                '/vendor/flasher/flasher-noty.min.js',
            ],
            'styles' => [
                '/vendor/flasher/noty.css',
                '/vendor/flasher/mint.css',
            ],
            'options' => [],
        ];

        $this->assertSame($expected, $this->notyPlugin->normalizeConfig([]));
    }
}
