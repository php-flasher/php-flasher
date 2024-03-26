<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Bag;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Storage\Bag\StaticBag;
use PHPUnit\Framework\TestCase;

final class StaticBagTest extends TestCase
{
    private StaticBag $staticBag;

    protected function setUp(): void
    {
        $this->staticBag = new StaticBag();
    }

    public function testGetAndSetMethods(): void
    {
        $this->assertSame([], $this->staticBag->get());

        $envelopes = [
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $this->staticBag->set($envelopes);

        $this->assertEquals($envelopes, $this->staticBag->get());
    }
}
