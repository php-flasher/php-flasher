<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\DelayStamp;
use PHPUnit\Framework\TestCase;

final class DelayStampTest extends TestCase
{
    private int $testDelay;
    private DelayStamp $instance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testDelay = 100;
        $this->instance = new DelayStamp($this->testDelay);
    }

    public function testGetDelay(): void
    {
        $delay = $this->instance->getDelay();

        $this->assertSame($this->testDelay, $delay);
    }

    public function testZeroDelayIsValid(): void
    {
        $stamp = new DelayStamp(0);

        $this->assertSame(0, $stamp->getDelay());
    }

    public function testNegativeDelayThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Delay must be a non-negative integer (>= 0).');

        new DelayStamp(-100);
    }
}
