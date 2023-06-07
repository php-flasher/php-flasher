<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Tests\Prime\TestCase;

final class ContextStampTest extends TestCase
{
    public function testContextStamp(): void
    {
        $stamp = new ContextStamp(['component' => 'livewire']);

        $this->assertInstanceOf(\Flasher\Prime\Stamp\StampInterface::class, $stamp);
        $this->assertInstanceOf(\Flasher\Prime\Stamp\PresentableStampInterface::class, $stamp);
        $this->assertEquals(['component' => 'livewire'], $stamp->getContext());
        $this->assertEquals(['context' => ['component' => 'livewire']], $stamp->toArray());
    }
}
