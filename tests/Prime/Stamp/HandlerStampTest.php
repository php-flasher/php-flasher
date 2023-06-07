<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Tests\Prime\TestCase;

final class HandlerStampTest extends TestCase
{
    public function testHandlerStamp(): void
    {
        $stamp = new HandlerStamp('toastr');

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresentableStampInterface::class, $stamp);
        $this->assertEquals('toastr', $stamp->getHandler());
        $this->assertEquals(['handler' => 'toastr'], $stamp->toArray());
    }
}
