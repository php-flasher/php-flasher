<?php

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Tests\Prime\TestCase;

class ContextStampTest extends TestCase
{
    /**
     * @return void
     */
    public function testContextStamp()
    {
        $stamp = new ContextStamp(['component' => 'livewire']);

        $this->assertInstanceOf('Flasher\Prime\Stamp\StampInterface', $stamp);
        $this->assertInstanceOf('Flasher\Prime\Stamp\PresentableStampInterface', $stamp);
        $this->assertEquals(['component' => 'livewire'], $stamp->getContext());
        $this->assertEquals(['context' => ['component' => 'livewire']], $stamp->toArray());
    }
}
