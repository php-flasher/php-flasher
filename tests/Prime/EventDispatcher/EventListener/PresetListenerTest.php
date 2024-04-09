<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\ApplyPresetListener;
use Flasher\Prime\Exception\PresetNotFoundException;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\Helper\ObjectInvader;
use PHPUnit\Framework\TestCase;

final class PresetListenerTest extends TestCase
{
    public function testPresetListener(): void
    {
        $eventDispatcher = new EventDispatcher();
        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new ApplyPresetListener([
            'entity_saved' => [
                'type' => 'success',
                'title' => 'PHPFlasher',
                'message' => 'success message',
                'options' => ['timeout' => 2500],
            ],
        ]);
        $eventDispatcher->addListener($listener);

        $envelopes = [
            new Envelope(new Notification(), new PresetStamp('entity_saved')),
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $envelopes = $event->getEnvelopes();

        $this->assertCount(2, $envelopes);
        $this->assertSame('success', $envelopes[0]->getType());
        $this->assertSame('PHPFlasher', $envelopes[0]->getTitle());
        $this->assertSame('success message', $envelopes[0]->getMessage());
        $this->assertSame(['timeout' => 2500], $envelopes[0]->getOptions());
    }

    public function testThrowExceptionIfPresetNotFound(): void
    {
        $this->expectException(
            PresetNotFoundException::class
        );
        $this->expectExceptionMessage(
            'Preset "entity_deleted" not found, did you forget to register it? Available presets: "entity_saved"'
        );

        $eventDispatcher = new EventDispatcher();
        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new ApplyPresetListener([
            'entity_saved' => [
                'type' => 'success',
                'title' => 'PHPFlasher',
                'message' => 'success message',
                'options' => ['timeout' => 2500],
            ],
        ]);
        $eventDispatcher->addListener($listener);

        $envelopes = [
            new Envelope(new Notification(), new PresetStamp('entity_deleted')),
            new Envelope(new Notification()),
        ];
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);
    }
}
