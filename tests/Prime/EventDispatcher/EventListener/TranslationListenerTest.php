<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Tests\Prime\Helper\ObjectInvader;
use PHPUnit\Framework\TestCase;

final class TranslationListenerTest extends TestCase
{
    public function testTranslationListenerWithAutoTranslateEnabled(): void
    {
        $eventDispatcher = new EventDispatcher();
        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new TranslationListener(new EchoTranslator());
        $eventDispatcher->addListener($listener);

        $notification = new Notification();
        $notification->setTitle('PHPFlasher');
        $notification->setMessage('success message');

        $envelopes = [
            new Envelope($notification),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $envelopes[0]->withStamp(new TranslationStamp(['resource' => 'resource'], 'ar'));
        $envelopes[0]->withStamp(new PresetStamp('entity_saved', ['resource' => 'resource']));

        $envelopes[1]->withStamp(new TranslationStamp(['resource' => 'resource'], 'ar'));
        $envelopes[1]->withStamp(new PresetStamp('entity_saved', ['resource' => 'resource']));

        $event = new PresentationEvent($envelopes, []);
        $eventDispatcher->dispatch($event);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }

    public function testTranslationListenerWithAutoTranslateDisabled(): void
    {
        $eventDispatcher = new EventDispatcher();
        ObjectInvader::from($eventDispatcher)->set('listeners', []);

        $listener = new TranslationListener(new EchoTranslator());
        $eventDispatcher->addListener($listener);

        $notification = new Notification();
        $notification->setTitle('PHPFlasher');
        $notification->setMessage('success message');

        $envelopes = [
            new Envelope($notification),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        ];

        $envelopes[0]->withStamp(new TranslationStamp(['resource' => 'resource'], 'ar'));
        $envelopes[0]->withStamp(new PresetStamp('entity_saved', ['resource' => 'resource']));

        $envelopes[1]->withStamp(new TranslationStamp(['resource' => 'resource'], 'ar'));
        $envelopes[1]->withStamp(new PresetStamp('entity_saved', ['resource' => 'resource']));

        $event = new PresentationEvent($envelopes, []);
        $eventDispatcher->dispatch($event);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
