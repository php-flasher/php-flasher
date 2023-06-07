<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\WhenStamp;
use Flasher\Tests\Prime\TestCase;

final class WhenStampTest extends TestCase
{
    public function testWhenStamp(): void
    {
        $stamp = new WhenStamp(true);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }
}
