<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Storage;

use Flasher\Laravel\Storage\FallbackSession;
use Flasher\Laravel\Storage\FallbackSessionInterface;
use Flasher\Laravel\Storage\SessionBag;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
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
        $sessionMock->expects()->put(SessionBag::ENVELOPES_NAMESPACE, array_map(serialize(...), $envelopes));

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

    public function testEnvelopeSurvivesJsonSerializationRoundTrip(): void
    {
        $notification = new Notification();
        $notification->setType('success');
        $notification->setMessage('Operation completed');

        $original = new Envelope($notification, [
            new IdStamp('json-test-id'),
            new HopsStamp(2),
            new DelayStamp(500),
        ]);

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->allows()->isStarted()->andReturns(true);

        $captured = null;
        $sessionMock->expects('put')->with(SessionBag::ENVELOPES_NAMESPACE, \Mockery::on(function ($value) use (&$captured) {
            $captured = $value;

            return true;
        }));

        $this->sessionManagerMock->allows()->driver()->andReturns($sessionMock);
        $this->sessionBag->set([$original]);

        $jsonEncoded = json_encode($captured, \JSON_THROW_ON_ERROR);
        $jsonDecoded = json_decode($jsonEncoded, true, 512, \JSON_THROW_ON_ERROR);

        $sessionMock->allows()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns($jsonDecoded);

        $restored = $this->sessionBag->get();

        $this->assertCount(1, $restored);
        $this->assertInstanceOf(Envelope::class, $restored[0]);
        $this->assertSame('success', $restored[0]->getType());
        $this->assertSame('Operation completed', $restored[0]->getMessage());
        $this->assertSame('json-test-id', $restored[0]->get(IdStamp::class)->getId());
        $this->assertSame(2, $restored[0]->get(HopsStamp::class)->getAmount());
        $this->assertSame(500, $restored[0]->get(DelayStamp::class)->getDelay());
    }

    public function testGetHandlesEnvelopeObjectsForBackwardCompatibility(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('legacy')),
        ];

        $envelopes[0]->setType('info');
        $envelopes[0]->setMessage('Old session');

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->expects()->isStarted()->andReturns(true);
        $sessionMock->expects()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns($envelopes);

        $this->sessionManagerMock->expects()->driver()->andReturns($sessionMock);

        $result = $this->sessionBag->get();

        $this->assertSame($envelopes, $result);
    }

    public function testGetSkipsCorruptedArrayData(): void
    {
        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->expects()->isStarted()->andReturns(true);
        $sessionMock->expects()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns([
            ['title' => '', 'message' => '', 'type' => 'success', 'options' => [], 'metadata' => ['id' => 'corrupted']],
        ]);

        $this->sessionManagerMock->expects()->driver()->andReturns($sessionMock);

        $result = $this->sessionBag->get();

        $this->assertSame([], $result);
    }

    public function testGetSkipsInvalidSerializedStrings(): void
    {
        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->expects()->isStarted()->andReturns(true);
        $sessionMock->expects()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns([
            'invalid-not-serialized-data',
            'O:8:"stdClass":0:{}',  // Valid serialized object but wrong type
            serialize(new Envelope(new Notification(), new IdStamp('valid'))),
        ]);

        $this->sessionManagerMock->expects()->driver()->andReturns($sessionMock);

        $result = $this->sessionBag->get();

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Envelope::class, $result[0]);
        $this->assertSame('valid', $result[0]->get(IdStamp::class)->getId());
    }

    public function testPreservesAllStampsAcrossRoundTrip(): void
    {
        $notification = new Notification();
        $notification->setType('warning');
        $notification->setMessage('Multi-stamp');

        $original = new Envelope($notification, [
            new IdStamp('stamp-test'),
            new HopsStamp(3),
            new DelayStamp(1000),
        ]);

        $serialized = serialize($original);
        $jsonEncoded = json_encode([$serialized], \JSON_THROW_ON_ERROR);
        $jsonDecoded = json_decode($jsonEncoded, true, 512, \JSON_THROW_ON_ERROR);

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->expects()->isStarted()->andReturns(true);
        $sessionMock->expects()->get(SessionBag::ENVELOPES_NAMESPACE, [])->andReturns($jsonDecoded);

        $this->sessionManagerMock->expects()->driver()->andReturns($sessionMock);

        $restored = $this->sessionBag->get();

        $this->assertCount(1, $restored);
        $this->assertInstanceOf(Envelope::class, $restored[0]);
        $this->assertSame('warning', $restored[0]->getType());
        $this->assertSame('Multi-stamp', $restored[0]->getMessage());
        $this->assertSame('stamp-test', $restored[0]->get(IdStamp::class)->getId());
        $this->assertSame(3, $restored[0]->get(HopsStamp::class)->getAmount());
        $this->assertSame(1000, $restored[0]->get(DelayStamp::class)->getDelay());
    }
}
