<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Storage;

use Flasher\Laravel\Storage\SessionBag;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Tests\Laravel\TestCase;
use Illuminate\Session\SessionManager;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;

final class SessionBagTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&SessionManager $sessionManagerMock;

    private SessionBag $sessionBag;

    protected function setUp(): void
    {
        $this->sessionManagerMock = \Mockery::mock(SessionManager::class);
        $this->sessionBag = new SessionBag($this->sessionManagerMock);
    }

    public function testGet(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $this->sessionManagerMock->expects()
            ->get(SessionBag::ENVELOPES_NAMESPACE, [])
            ->andReturns($envelopes);

        $this->assertEquals($envelopes, $this->sessionBag->get());
    }

    public function testSet(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $this->sessionManagerMock->allows()
            ->get(SessionBag::ENVELOPES_NAMESPACE, [])
            ->andReturns($envelopes);

        $this->sessionManagerMock->expects()
            ->put(SessionBag::ENVELOPES_NAMESPACE, $envelopes);

        $this->sessionBag->set($envelopes);

        $this->assertSame($envelopes, $this->sessionBag->get());
    }
}
