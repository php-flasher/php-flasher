<?php

declare(strict_types=1);

namespace Flasher\Tests\Notyf\Prime;

use Flasher\Notyf\Prime\Notyf;
use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Notyf\Prime\NotyfPlugin;
use PHPUnit\Framework\TestCase;

final class NotyfPluginTest extends TestCase
{
    private NotyfPlugin $notyfPlugin;

    protected function setUp(): void
    {
        $this->notyfPlugin = new NotyfPlugin();
    }

    public function testGetAlias(): void
    {
        $this->assertSame('notyf', $this->notyfPlugin->getAlias());
    }

    public function testGetFactory(): void
    {
        $this->assertSame(Notyf::class, $this->notyfPlugin->getFactory());
    }

    public function testGetServiceAliases(): void
    {
        $this->assertSame(NotyfInterface::class, $this->notyfPlugin->getServiceAliases());
    }

    public function testGetScripts(): void
    {
        $this->assertSame(['/vendor/flasher/flasher-notyf.min.js'], $this->notyfPlugin->getScripts());
    }

    public function testGetStyles(): void
    {
        $this->assertSame(['/vendor/flasher/flasher-notyf.min.css'], $this->notyfPlugin->getStyles());
    }

    public function testGetName(): void
    {
        $this->assertSame('flasher_notyf', $this->notyfPlugin->getName());
    }

    public function testGetServiceId(): void
    {
        $this->assertSame('flasher.notyf', $this->notyfPlugin->getServiceId());
    }

    public function testNormalizeConfig(): void
    {
        $expected = [
            'scripts' => ['/vendor/flasher/flasher-notyf.min.js'],
            'styles' => ['/vendor/flasher/flasher-notyf.min.css'],
            'options' => [],
        ];

        $this->assertSame($expected, $this->notyfPlugin->normalizeConfig([]));
    }
}
