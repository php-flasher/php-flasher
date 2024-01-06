<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Tests\Prime\TestCase;

final class UuidStampTest extends TestCase
{
    public function testUuidStamp(): void
    {
        $stamp = new IdStamp();

        $this->assertInstanceOf(StampInterface::class, $stamp);
        $this->assertNotEmpty($stamp->getId());

        $stamp = new IdStamp('aaaa-bbbb-cccc');
        $this->assertEquals('aaaa-bbbb-cccc', $stamp->getId());
        $this->assertEquals(['id' => 'aaaa-bbbb-cccc'], $stamp->toArray());
    }
}
