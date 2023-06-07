<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Tests\Prime\TestCase;

final class HopsStampTest extends TestCase
{
    public function testHopsStamp(): void
    {
        $stamp = new HopsStamp(5);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertEquals(5, $stamp->getAmount());
    }
}
