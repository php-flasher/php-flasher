<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Tests\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventListener\PresetListener;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Tests\Prime\TestCase;

class PresetListenerTest extends TestCase
{
    /**
     * @return void
     */
    public function testPresetListener()
    {
        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new PresetListener(array(
            'entity_saved' => array(
                'type' => 'success',
                'title' => 'PHPFlasher',
                'message' => 'success message',
                'options' => array('timeout' => 2500),
            ),
        ));
        $eventDispatcher->addSubscriber($listener);

        $envelopes = array(
            new Envelope(new Notification(), new PresetStamp('entity_saved')),
            new Envelope(new Notification()),
        );
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);

        $envelopes = $event->getEnvelopes();

        $this->assertCount(2, $envelopes);
        $this->assertEquals('success', $envelopes[0]->getType());
        $this->assertEquals('PHPFlasher', $envelopes[0]->getTitle());
        $this->assertEquals('success message', $envelopes[0]->getMessage());
        $this->assertEquals(array('timeout' => 2500), $envelopes[0]->getOptions());
    }

    /**
     * @return void
     */
    public function testThrowExceptionIfPresetNotFound()
    {
        $this->setExpectedException(
            'Flasher\Prime\Exception\PresetNotFoundException',
            'Preset "entity_deleted" not found, did you forget to register it? Available presets: entity_saved'
        );

        $eventDispatcher = new EventDispatcher();
        $this->setProperty($eventDispatcher, 'listeners', array());

        $listener = new PresetListener(array(
            'entity_saved' => array(
                'type' => 'success',
                'title' => 'PHPFlasher',
                'message' => 'success message',
                'options' => array('timeout' => 2500),
            ),
        ));
        $eventDispatcher->addSubscriber($listener);

        $envelopes = array(
            new Envelope(new Notification(), new PresetStamp('entity_deleted')),
            new Envelope(new Notification()),
        );
        $event = new PersistEvent($envelopes);

        $eventDispatcher->dispatch($event);
    }
}
