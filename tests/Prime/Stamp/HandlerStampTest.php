<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;
use PHPUnit\Framework\TestCase;

final class HandlerStampTest extends TestCase
{
    public function testHandlerStamp(): void
    {
        $stamp = new PluginStamp('toastr');

        $this->assertInstanceOf(StampInterface::class, $stamp);
        $this->assertInstanceOf(PresentableStampInterface::class, $stamp);
        $this->assertSame('toastr', $stamp->getPlugin());
        $this->assertSame(['plugin' => 'toastr'], $stamp->toArray());
    }
}
