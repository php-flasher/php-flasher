<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HopsStamp;
use PHPUnit\Framework\TestCase;

final class HopsStampTest extends TestCase
{
    /*
     * Test to verify that calling getAmount on a HopsStamp instance
     * with a certain initial amount correctly returns that amount.
     */
    public function testGetAmount(): void
    {
        $initialAmount = 5;
        $hopsStamp = new HopsStamp($initialAmount);

        $this->assertSame($initialAmount, $hopsStamp->getAmount());
    }

    public function testZeroHopsThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Hops amount must be a positive integer (>= 1).');

        new HopsStamp(0);
    }

    public function testNegativeHopsThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Hops amount must be a positive integer (>= 1).');

        new HopsStamp(-5);
    }

    public function testMinimumValidHops(): void
    {
        $stamp = new HopsStamp(1);

        $this->assertSame(1, $stamp->getAmount());
    }
}
