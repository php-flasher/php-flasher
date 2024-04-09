<?php

declare(strict_types=1);

namespace Flasher\Tests\Toastr\Prime;

use Flasher\Toastr\Prime\Toastr;
use Flasher\Toastr\Prime\ToastrInterface;
use Flasher\Toastr\Prime\ToastrPlugin;
use PHPUnit\Framework\TestCase;

final class ToastrPluginTest extends TestCase
{
    private ToastrPlugin $toastrPlugin;

    protected function setUp(): void
    {
        $this->toastrPlugin = new ToastrPlugin();
    }

    public function testGetAlias(): void
    {
        $this->assertSame('toastr', $this->toastrPlugin->getAlias());
    }

    public function testGetFactory(): void
    {
        $this->assertSame(Toastr::class, $this->toastrPlugin->getFactory());
    }

    public function testGetServiceAliases(): void
    {
        $this->assertSame(ToastrInterface::class, $this->toastrPlugin->getServiceAliases());
    }

    public function testGetScripts(): void
    {
        $this->assertSame([
            '/vendor/flasher/jquery.min.js',
            '/vendor/flasher/toastr.min.js',
            '/vendor/flasher/flasher-toastr.min.js',
        ], $this->toastrPlugin->getScripts());
    }

    public function testGetStyles(): void
    {
        $this->assertSame(['/vendor/flasher/toastr.min.css'], $this->toastrPlugin->getStyles());
    }

    public function testGetName(): void
    {
        $this->assertSame('flasher_toastr', $this->toastrPlugin->getName());
    }

    public function testGetServiceId(): void
    {
        $this->assertSame('flasher.toastr', $this->toastrPlugin->getServiceId());
    }

    public function testNormalizeConfig(): void
    {
        $expected = [
            'scripts' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/toastr.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => ['/vendor/flasher/toastr.min.css'],
            'options' => [],
        ];

        $this->assertSame($expected, $this->toastrPlugin->normalizeConfig([]));
    }
}
