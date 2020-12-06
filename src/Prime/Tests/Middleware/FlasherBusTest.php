<?php

namespace Flasher\Prime\Tests\Middleware;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Envelope;
use Flasher\Prime\Middleware\AddCreatedAtStampMiddleware;
use Flasher\Prime\Middleware\AddPriorityStampMiddleware;
use Flasher\Prime\Middleware\FlasherBus;
use Flasher\Prime\Stamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class FlasherBusTest extends TestCase
{
    public function testHandle()
    {
        $config = new Config(array(
            'default' => 'notify',
            'adapters' => array(
                'notify' => array(
                    'scripts' => array('script.js'),
                    'styles' => array('styles.css'),
                    'options' => array()
                )
            ),
            'stamps_middlewares' => array(
                new AddPriorityStampMiddleware(),
                new AddCreatedAtStampMiddleware(),
            )
        ));

        $stack = new FlasherBus($config);

        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $envelope     = new Envelope($notification);

        $stack->handle($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(3, $envelope->all());

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertInstanceOf('Flasher\Prime\Stamp\PriorityStamp', $priorityStamp);
//        $this->assertEquals(0, $priorityStamp->getPriority());

        $timeStamp = $envelope->get('Flasher\Prime\Stamp\CreatedAtStamp');
        $this->assertInstanceOf('Flasher\Prime\Stamp\CreatedAtStamp', $timeStamp);

        $this->assertEquals(time(), $timeStamp->getCreatedAt()->getTimestamp());
    }

    public function testHandleWithExistingStamps()
    {
        $config = new Config(array(
            'default' => 'notify',
            'adapters' => array(
                'notify' => array(
                    'scripts' => array('script.js'),
                    'styles' => array('styles.css'),
                    'options' => array()
                )
            ),
            'stamps_middlewares' => array(
                new AddPriorityStampMiddleware(),
                new AddCreatedAtStampMiddleware(),
            )
        ));

        $stack = new FlasherBus($config);

        $notification = $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock();
        $stamps       = array(
            new PriorityStamp(1),
        );
        $envelope     = new Envelope($notification, $stamps);

        $stack->handle($envelope);

        $this->assertSame($notification, $envelope->getNotification());
        $this->assertCount(3, $envelope->all());

        $priorityStamp = $envelope->get('Flasher\Prime\Stamp\PriorityStamp');
        $this->assertInstanceOf('Flasher\Prime\Stamp\PriorityStamp', $priorityStamp);
//        $this->assertEquals(1, $priorityStamp->getPriority());
    }
}
