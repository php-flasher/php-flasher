<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Tests\Prime\TestCase;

final class DelayStampTest extends TestCase
{
    public function testDelayStamp(): void
    {
        $stamp = new DelayStamp(2);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertEquals(2, $stamp->getDelay());
    }
}
