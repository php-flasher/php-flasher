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

    public function testConstructorWithNullGeneratesUniqueId(): void
    {
        $stamp = new IdStamp();

        $this->assertNotEmpty($stamp->getId());
        $this->assertIsString($stamp->getId());
        $this->assertSame(32, \strlen($stamp->getId())); // 16 bytes = 32 hex chars
    }

    public function testConstructorWithProvidedId(): void
    {
        $knownId = 'KnownID123';
        $stamp = new IdStamp($knownId);

        $this->assertSame($knownId, $stamp->getId());
    }

    public function testConstructorGeneratesUniqueIds(): void
    {
        $stamp1 = new IdStamp();
        $stamp2 = new IdStamp();

        $this->assertNotSame($stamp1->getId(), $stamp2->getId());
    }

    public function testGetIdReturnsSameValue(): void
    {
        $stamp = new IdStamp();
        $id1 = $stamp->getId();
        $id2 = $stamp->getId();

        $this->assertSame($id1, $id2);
    }

    public function testToArray(): void
    {
        $stamp = new IdStamp();
        $array = $stamp->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertSame($stamp->getId(), $array['id']);
    }

    public function testToArrayWithKnownId(): void
    {
        $knownId = 'custom-id-12345';
        $stamp = new IdStamp($knownId);
        $array = $stamp->toArray();

        $this->assertSame(['id' => $knownId], $array);
    }

    public function testIndexByIdWithExistingStamps(): void
    {
        $stamp1 = new IdStamp('1111');
        $stamp2 = new IdStamp('2222');

        $envelope1 = new Envelope(new Notification(), $stamp1);
        $envelope2 = new Envelope(new Notification(), $stamp2);

        $map = IdStamp::indexById([$envelope1, $envelope2]);

        $this->assertCount(2, $map);
        $this->assertArrayHasKey('1111', $map);
        $this->assertArrayHasKey('2222', $map);
        $this->assertSame($envelope1, $map['1111']);
        $this->assertSame($envelope2, $map['2222']);
    }

    public function testIndexByIdWithoutStampsCreatesNewOnes(): void
    {
        $envelope1 = new Envelope(new Notification());
        $envelope2 = new Envelope(new Notification());

        // Initially, envelopes don't have IdStamp
        $this->assertNull($envelope1->get(IdStamp::class));
        $this->assertNull($envelope2->get(IdStamp::class));

        $map = IdStamp::indexById([$envelope1, $envelope2]);

        $this->assertCount(2, $map);

        // Now envelopes should have IdStamp
        $this->assertInstanceOf(IdStamp::class, $envelope1->get(IdStamp::class));
        $this->assertInstanceOf(IdStamp::class, $envelope2->get(IdStamp::class));

        // Verify the map keys match the new stamps
        $keys = array_keys($map);
        $this->assertSame($envelope1->get(IdStamp::class)->getId(), $keys[0]);
        $this->assertSame($envelope2->get(IdStamp::class)->getId(), $keys[1]);
    }

    public function testIndexByIdWithMixedEnvelopes(): void
    {
        $existingStamp = new IdStamp('existing-id');
        $envelopeWithStamp = new Envelope(new Notification(), $existingStamp);
        $envelopeWithoutStamp = new Envelope(new Notification());

        $map = IdStamp::indexById([$envelopeWithStamp, $envelopeWithoutStamp]);

        $this->assertCount(2, $map);
        $this->assertArrayHasKey('existing-id', $map);
        $this->assertSame($envelopeWithStamp, $map['existing-id']);

        // The second envelope should have a new stamp
        $newStamp = $envelopeWithoutStamp->get(IdStamp::class);
        $this->assertInstanceOf(IdStamp::class, $newStamp);
        $this->assertArrayHasKey($newStamp->getId(), $map);
    }

    public function testIndexByIdWithEmptyArray(): void
    {
        $map = IdStamp::indexById([]);

        $this->assertSame([], $map);
        $this->assertCount(0, $map);
    }

    public function testIndexByIdPreservesEnvelopeReferences(): void
    {
        $notification = new Notification();
        $notification->setMessage('Test Message');
        $envelope = new Envelope($notification);

        $map = IdStamp::indexById([$envelope]);

        $returnedEnvelope = array_values($map)[0];
        $this->assertSame('Test Message', $returnedEnvelope->getMessage());
    }

    public function testIdStampIsImmutable(): void
    {
        $stamp = new IdStamp('immutable-id');

        // IdStamp is readonly, so the ID cannot change
        $this->assertSame('immutable-id', $stamp->getId());
        $this->assertSame('immutable-id', $stamp->toArray()['id']);
    }

    public function testGeneratedIdIsHexadecimal(): void
    {
        $stamp = new IdStamp();
        $id = $stamp->getId();

        // Should be valid hexadecimal
        $this->assertMatchesRegularExpression('/^[0-9a-f]+$/', $id);
    }

    public function testIndexByIdWithSingleEnvelope(): void
    {
        $stamp = new IdStamp('single');
        $envelope = new Envelope(new Notification(), $stamp);

        $map = IdStamp::indexById([$envelope]);

        $this->assertCount(1, $map);
        $this->assertArrayHasKey('single', $map);
        $this->assertSame($envelope, $map['single']);
    }

    public function testIndexByIdWithManyEnvelopes(): void
    {
        $envelopes = [];
        for ($i = 0; $i < 100; ++$i) {
            $envelopes[] = new Envelope(new Notification(), new IdStamp("id-{$i}"));
        }

        $map = IdStamp::indexById($envelopes);

        $this->assertCount(100, $map);
        for ($i = 0; $i < 100; ++$i) {
            $this->assertArrayHasKey("id-{$i}", $map);
        }
    }
}
