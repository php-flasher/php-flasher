<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Tests\Prime\TestCase;

final class UuidStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testUuidStamp()
    {
        $stamp = new UuidStamp();

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertNotEmpty($stamp->getUuid());

        $stamp = new UuidStamp('aaaa-bbbb-cccc');
        $this->assertEquals('aaaa-bbbb-cccc', $stamp->getUuid());
        $this->assertEquals(['uuid' => 'aaaa-bbbb-cccc'], $stamp->toArray());
    }
}
