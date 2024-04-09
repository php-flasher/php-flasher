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
}
