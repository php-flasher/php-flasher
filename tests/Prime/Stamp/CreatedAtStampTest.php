<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\CreatedAtStamp;
use PHPUnit\Framework\TestCase;

final class CreatedAtStampTest extends TestCase
{
    private \DateTimeImmutable $time;

    private CreatedAtStamp $createdAtStamp;

    private string $format;

    protected function setUp(): void
    {
        $this->time = new \DateTimeImmutable('2023-01-01 12:00:00');
        $this->format = 'Y-m-d H:i:s';
        $this->createdAtStamp = new CreatedAtStamp($this->time, $this->format);
    }

    /**
     * Test getCreatedAt method to ensure it returns correct DateTimeImmutable object.
     */
    public function testGetCreatedAt(): void
    {
        $createdAt = $this->createdAtStamp->getCreatedAt();
        $this->assertInstanceOf(\DateTimeImmutable::class, $createdAt);
    }

    /**
     * Test if the format of the datetime object returned by getCreatedAt matches the expected format.
     */
    public function testGetCreatedAtFormat(): void
    {
        $createdAt = $this->createdAtStamp->getCreatedAt();
        $formattedDate = $createdAt->format($this->format);
        $expectedDate = $this->time->format($this->format);
        $this->assertSame($expectedDate, $formattedDate);
    }

    /**
     * Test compare method to compare timestamps correctly.
     */
    public function testCompare(): void
    {
        // Testing with a time exactly 1 second later
        $laterTime = $this->time->modify('+1 second');
        $laterStamp = new CreatedAtStamp($laterTime, $this->format);

        // Testing with the same time
        $sameStamp = new CreatedAtStamp($this->time, $this->format);

        // laterStamp should be "greater" than createdAtStamp
        $this->assertSame(-1, $this->createdAtStamp->compare($laterStamp));
        $this->assertSame(1, $laterStamp->compare($this->createdAtStamp));

        // Comparing with the same time should result in 0
        $this->assertSame(0, $this->createdAtStamp->compare($sameStamp));
    }

    /**
     * Test toArray method to return correct array format.
     */
    public function testToArray(): void
    {
        $arrayForm = $this->createdAtStamp->toArray();
        $this->assertArrayHasKey('created_at', $arrayForm);
        $this->assertSame($this->time->format($this->format), $arrayForm['created_at']);
    }
}
