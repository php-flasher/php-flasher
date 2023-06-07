<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Tests\Prime\TestCase;

final class UnlessStampTest extends TestCase
{
    public function testUnlessStamp(): void
    {
        $stamp = new UnlessStamp(true);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertTrue($stamp->getCondition());
    }
}
