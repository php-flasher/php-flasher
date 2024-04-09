<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\WhenStamp;
use PHPUnit\Framework\TestCase;

final class WhenStampTest extends TestCase
{
    public function testGetCondition(): void
    {
        $whenStamp = new WhenStamp(true);
        $this->assertTrue($whenStamp->getCondition());

        $whenStamp = new WhenStamp(false);
        $this->assertFalse($whenStamp->getCondition());
    }
}
