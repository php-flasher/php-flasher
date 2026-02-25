<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Storage;

use Flasher\Laravel\Storage\FallbackSession;
use Flasher\Laravel\Storage\FallbackSessionInterface;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Tests\Laravel\TestCase;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;

final class SessionBagTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&SessionManager $sessionManagerMock;

    private SessionBag $sessionBag;

    protected function setUp(): void
    {
        parent::setUp();

        FallbackSession::reset();
        $this->sessionManagerMock = \Mockery::mock(SessionManager::class);
        $this->sessionBag = new SessionBag($this->sessionManagerMock);
    }

    protected function tearDown(): void
    {
        FallbackSession::reset();
        parent::tearDown();
    }

    public function testGet(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->expects()->isStarted()->andReturns(true);
        $sessionMock->expects()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns($envelopes);

        $this->sessionManagerMock->expects()->driver()->andReturns($sessionMock);

        $this->assertEquals($envelopes, $this->sessionBag->get());
    }

    public function testSet(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(true);
        $sessionMock->allows()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns($envelopes);
        $sessionMock->expects()->put(SessionBag::ENVELOPES_NAMESPACE, $envelopes);

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);

        $this->sessionBag->set($envelopes);

        $this->assertSame($envelopes, $this->sessionBag->get());
    }

    public function testUsesFallbackSessionWhenSessionNotStarted(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('fallback-1')),
        ];

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(false);

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);

        $this->sessionBag->set($envelopes);

        $this->assertSame($envelopes, $this->sessionBag->get());
    }

    public function testCustomFallbackSession(): void
    {
        $customFallback = new class implements FallbackSessionInterface {
            /** @var array<string, mixed> */
            private array $data = [];

            public function get(string $name, mixed $default = null): mixed
            {
                return $this->data[$name] ?? $default;
            }

            public function set(string $name, mixed $value): void
            {
                $this->data[$name] = $value;
            }
        };

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(false);

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);

        $sessionBag = new SessionBag($this->sessionManagerMock, $customFallback);

        $envelopes = [
            new Envelope(new Notification(), new IdStamp('custom-fallback')),
        ];

        $sessionBag->set($envelopes);

        $this->assertSame($envelopes, $sessionBag->get());
    }

    public function testFallbackSessionIsStatic(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('static-test')),
        ];

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(false);

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);

        $this->sessionBag->set($envelopes);

        $sessionBag2 = new SessionBag($this->sessionManagerMock);

        $this->assertSame($envelopes, $sessionBag2->get());
    }

    public function testFallbackSessionResetClearsData(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('reset-test')),
        ];

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(false);

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);

        $this->sessionBag->set($envelopes);
        $this->assertSame($envelopes, $this->sessionBag->get());

        FallbackSession::reset();

        $this->assertSame([], $this->sessionBag->get());
    }

    public function testEmptyEnvelopesReturnsEmptyArray(): void
    {
        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->expects()->isStarted()->andReturns(true);
        $sessionMock->expects()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns([]);

        $this->sessionManagerMock->expects()->driver()->andReturns($sessionMock);

        $this->assertSame([], $this->sessionBag->get());
    }

    public function testOverwritesExistingEnvelopes(): void
    {
        $envelopes1 = [
            new Envelope(new Notification(), new IdStamp('first')),
        ];

        $envelopes2 = [
            new Envelope(new Notification(), new IdStamp('second')),
        ];

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(true);
        $sessionMock->allows()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns($envelopes2);
        $sessionMock->allows()->put(SessionBag::ENVELOPES_NAMESPACE, \Mockery::any())->twice();

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);

        $this->sessionBag->set($envelopes1);
        $this->sessionBag->set($envelopes2);

        $this->assertSame($envelopes2, $this->sessionBag->get());
    }
}
