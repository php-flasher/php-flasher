<?php

declare(strict_types=1);

namespace Flasher\Tests\SweetAlert\Prime;

use Flasher\SweetAlert\Prime\SweetAlert;
use Flasher\SweetAlert\Prime\SweetAlertInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use PHPUnit\Framework\TestCase;

final class SweetAlertPluginTest extends TestCase
{
    private SweetAlertPlugin $sweetAlertPlugin;

    protected function setUp(): void
    {
        $this->sweetAlertPlugin = new SweetAlertPlugin();
    }

    public function testGetAlias(): void
    {
        $this->assertSame('sweetalert', $this->sweetAlertPlugin->getAlias());
    }

    public function testGetFactory(): void
    {
        $this->assertSame(SweetAlert::class, $this->sweetAlertPlugin->getFactory());
    }

    public function testGetServiceAliases(): void
    {
        $this->assertSame(SweetAlertInterface::class, $this->sweetAlertPlugin->getServiceAliases());
    }

    public function testGetScripts(): void
    {
        $this->assertSame([
            '/vendor/flasher/sweetalert2.min.js',
            '/vendor/flasher/flasher-sweetalert.min.js',
        ], $this->sweetAlertPlugin->getScripts());
    }

    public function testGetStyles(): void
    {
        $this->assertSame(['/vendor/flasher/sweetalert2.min.css'], $this->sweetAlertPlugin->getStyles());
    }

    public function testGetName(): void
    {
        $this->assertSame('flasher_sweetalert', $this->sweetAlertPlugin->getName());
    }

    public function testGetServiceId(): void
    {
        $this->assertSame('flasher.sweetalert', $this->sweetAlertPlugin->getServiceId());
    }

    public function testNormalizeConfig(): void
    {
        $expected = [
            'scripts' => [
                '/vendor/flasher/sweetalert2.min.js',
                '/vendor/flasher/flasher-sweetalert.min.js',
            ],
            'styles' => ['/vendor/flasher/sweetalert2.min.css'],
            'options' => [],
        ];

        $this->assertSame($expected, $this->sweetAlertPlugin->normalizeConfig([]));
    }
}
