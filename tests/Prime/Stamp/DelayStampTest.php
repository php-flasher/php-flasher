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
        $this->testDelay = 100;
        $this->instance = new DelayStamp($this->testDelay);
    }

    public function testGetDelay(): void
    {
        $delay = $this->instance->getDelay();

        $this->assertSame($this->testDelay, $delay);
    }
}
