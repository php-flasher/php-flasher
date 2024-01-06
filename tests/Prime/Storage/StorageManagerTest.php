<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage;

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
use Flasher\Tests\Prime\TestCase;

final class StorageManagerTest extends TestCase
{
    public function testGetAllStoredEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $filterFactory = $this->createMock(FilterFactoryInterface::class);

        $storageManager = new StorageManager($storage, $eventDispatcher, $filterFactory);

        $this->assertEquals($envelopes, $storageManager->all());
    }

    public function testGetFilteredEnvelopes(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), [new IdStamp('2222'), new HopsStamp(1), new DelayStamp(0)]),
            new Envelope(new Notification(), new IdStamp('3333')),
            new Envelope(new Notification(), new IdStamp('4444')),
        ];

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects($this->once())->method('all')->willReturn($envelopes);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $filterFactory = $this->createMock(FilterFactoryInterface::class);
        $filterFactory->method('createFilter')->willReturn(new Filter());

        $storageManager = new StorageManager($storage, $eventDispatcher, $filterFactory);

        $this->assertEquals($envelopes, $storageManager->filter());
    }
}
