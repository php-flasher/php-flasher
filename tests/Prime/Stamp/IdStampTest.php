<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

final class IdStampTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * TestCase for constructor and `getId`.
     */
    public function testConstructorAndGetId(): void
    {
        // Test with null ID
        $ifStamp = new IdStamp();
        $this->assertIsString($ifStamp->getId());

        // Test with known ID
        $knownId = 'KnownID123';
        $StampWithKnownId = new IdStamp($knownId);

        $this->assertSame($knownId, $StampWithKnownId->getId());
    }

    /**
     * Test `toArray` method.
     */
    public function testToArray(): void
    {
        $ifStamp = new IdStamp();
        $arrayRepresentation = $ifStamp->toArray();
        $this->assertIsArray($arrayRepresentation);
        $this->assertArrayHasKey('id', $arrayRepresentation);
        $this->assertSame($arrayRepresentation['id'], $ifStamp->getId());
    }

    /**
     * Tests `indexById` function.
     */
    public function testIndexById(): void
    {
        $stamp1 = new IdStamp('1111');
        $stamp2 = new IdStamp('2222');

        $envelope1 = new Envelope(new Notification(), $stamp1);
        $envelope2 = new Envelope(new Notification(), $stamp2);

        $map = IdStamp::indexById([$envelope1, $envelope2]);

        $this->assertCount(2, $map);
        $this->assertArrayHasKey($stamp1->getId(), $map);
        $this->assertSame($envelope1, $map[$stamp1->getId()]);
        $this->assertArrayHasKey($stamp2->getId(), $map);
        $this->assertSame($envelope2, $map[$stamp2->getId()]);
    }
}
