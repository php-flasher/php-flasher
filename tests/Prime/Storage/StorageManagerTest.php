<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage;

use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\Event\PostPersistEvent;
use Flasher\Prime\EventDispatcher\Event\PostRemoveEvent;
use Flasher\Prime\EventDispatcher\Event\PostUpdateEvent;
use Flasher\Prime\EventDispatcher\Event\RemoveEvent;
use Flasher\Prime\EventDispatcher\Event\UpdateEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Filter\Filter;
use Flasher\Prime\Storage\Filter\FilterFactoryInterface;
use Flasher\Prime\Storage\StorageInterface;
use Flasher\Prime\Storage\StorageManager;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class StorageManagerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&StorageInterface $storageMock;
    private MockInterface&FilterFactoryInterface $filterFactoryMock;
    private MockInterface&EventDispatcherInterface $eventDispatcherMock;
    private StorageManager $storageManager;

    protected function setUp(): void
    {
        $this->storageMock = \Mockery::mock(StorageInterface::class);
        $this->filterFactoryMock = \Mockery::mock(FilterFactoryInterface::class);
        $this->eventDispatcherMock = \Mockery::mock(EventDispatcherInterface::class);

        $this->storageManager = new StorageManager($this->storageMock, $this->eventDispatcherMock, $this->filterFactoryMock);
    }

    public function testAll(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $this->storageMock->expects()->all()->once()->andReturns($envelopes);

        $this->assertSame($envelopes, $this->storageManager->all());
    }

    public function testGetFilteredEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), [new IdStamp('2222'), new HopsStamp(1), new DelayStamp(0)]),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $this->storageMock->expects()->all()->once()->andReturns($envelopes);
        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(FilterEvent::class))->once();
        $this->filterFactoryMock->expects()->createFilter([])->andReturns(new Filter());

        $this->assertSame($envelopes, $this->storageManager->filter());
    }

    public function testAdd(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(PersistEvent::class))->once();
        $this->storageMock->expects()->add(...$envelopes)->once();
        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(PostPersistEvent::class))->once();

        $this->storageManager->add(...$envelopes);
    }

    public function testUpdate(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('5555')),
            new Envelope(new Notification(), new IdStamp('6666')),
        ];

        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(UpdateEvent::class))->once();
        $this->storageMock->expects()->update(...$envelopes)->once();
        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(PostUpdateEvent::class))->once();

        $this->storageManager->update(...$envelopes);
    }

    public function testRemove(): void
    {
        $envelopesToRemove = [
            new Envelope(new Notification(), new IdStamp('7777')),
            new Envelope(new Notification(), new IdStamp('8888')),
        ];

        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(RemoveEvent::class))->once();
        $this->storageMock->expects()->remove(...$envelopesToRemove)->once();
        $this->storageMock->expects()->update()->once();
        $this->eventDispatcherMock->expects()->dispatch(\Mockery::type(PostRemoveEvent::class))->once();

        $this->storageManager->remove(...$envelopesToRemove);
    }

    public function testClear(): void
    {
        $this->storageMock->expects()->clear()->once();

        $this->storageManager->clear();
    }
}
