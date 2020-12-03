<?php

namespace Flasher\Prime\Tests\Filter;

use Notify\Config\Config;
use Flasher\Prime\Envelope;
use Flasher\Prime\Middleware\AddCreatedAtStampMiddleware;
use Flasher\Prime\Middleware\AddPriorityStampMiddleware;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Tests\TestCase;

final class DefaultFilterTest extends TestCase
{
    public function testWithCriteria()
    {
        $notifications = array(
            $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock(),
        );

        $notifications[3] = new Envelope(
            $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(5))
        );

        $notifications[4] = new Envelope(
            $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(-1))
        );

        $notifications[5] = new Envelope(
            $this->getMockBuilder('Flasher\Prime\Notification\NotificationInterface')->getMock(),
            array(new PriorityStamp(1))
        );

        $config = new Config(
            array(
                'default'            => 'notify',
                'adapters'           => array(
                    'notify' => array(
                        'scripts' => array('script.js'),
                        'styles'  => array('styles.css'),
                        'options' => array()
                    )
                ),
                'stamps_middlewares' => array(
                    new AddPriorityStampMiddleware(),
                    new AddCreatedAtStampMiddleware(),
                )
            )
        );
    }
}
