<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\TestCase;

final class PresetListenerTest extends TestCase
{
    public function testPresetListener(): void
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', []);

        $listener = new ApplyPresetListener([
            'entity_saved' => [
                'type' => 'success',
                'title' => 'PHPFlasher',
                'message' => 'success message',
                'options' => ['timeout' => 2500],
            ],
        ]);
        $eventDispatcher->addSubscriber($listener);

        $envelopes = [
            new Envelope(new Notification(), new PresetStamp('entity_saved')),
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $envelopes = $event->getEnvelopes();

        $this->assertCount(2, $envelopes);
        $this->assertEquals('success', $envelopes[0]->getType());
        $this->assertEquals('PHPFlasher', $envelopes[0]->getTitle());
        $this->assertEquals('success message', $envelopes[0]->getMessage());
        $this->assertEquals(['timeout' => 2500], $envelopes[0]->getOptions());
    }

    public function testThrowExceptionIfPresetNotFound(): void
    {
        $this->setExpectedException(
            \Flasher\Prime\Exception\PresetNotFoundException::class,
            'Preset "entity_deleted" not found, did you forget to register it? Available presets: entity_saved'
        );

        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', []);

        $listener = new ApplyPresetListener([
            'entity_saved' => [
                'type' => 'success',
                'title' => 'PHPFlasher',
                'message' => 'success message',
                'options' => ['timeout' => 2500],
            ],
        ]);
        $eventDispatcher->addSubscriber($listener);

        $envelopes = [
            new Envelope(new Notification(), new PresetStamp('entity_deleted')),
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);
    }
}
