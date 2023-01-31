<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\TranslationListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Tests\Prime\TestCase;

class TranslationListenerTest extends TestCase
{
    /**
     * @return void
     */
    public function testTranslationListenerWithAutoTranslateEnabled()
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new TranslationListener(new EchoTranslator(), true);
        $eventDispatcher->addSubscriber($listener);

        $notification = new Notification();
        $notification->setTitle('PHPFlasher');
        $notification->setMessage('success message');

        $envelopes = array(
            new Envelope($notification),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $envelopes[0]->withStamp(new TranslationStamp(array('resource' => 'resource'), 'ar'));
        $envelopes[0]->withStamp(new PresetStamp('entity_saved', array('resource' => 'resource')));

        $envelopes[1]->withStamp(new TranslationStamp(array('resource' => 'resource'), 'ar'));
        $envelopes[1]->withStamp(new PresetStamp('entity_saved', array('resource' => 'resource')));

        $event = new PresentationEvent($envelopes, array());
        $eventDispatcher->dispatch($event);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }

    /**
     * @return void
     */
    public function testTranslationListenerWithAutoTranslateDisabled()
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new TranslationListener(new EchoTranslator(), false);
        $eventDispatcher->addSubscriber($listener);

        $notification = new Notification();
        $notification->setTitle('PHPFlasher');
        $notification->setMessage('success message');

        $envelopes = array(
            new Envelope($notification),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $envelopes[0]->withStamp(new TranslationStamp(array('resource' => 'resource'), 'ar'));
        $envelopes[0]->withStamp(new PresetStamp('entity_saved', array('resource' => 'resource')));

        $envelopes[1]->withStamp(new TranslationStamp(array('resource' => 'resource'), 'ar'));
        $envelopes[1]->withStamp(new PresetStamp('entity_saved', array('resource' => 'resource')));

        $event = new PresentationEvent($envelopes, array());
        $eventDispatcher->dispatch($event);

        $this->assertEquals($envelopes, $event->getEnvelopes());
    }
}
