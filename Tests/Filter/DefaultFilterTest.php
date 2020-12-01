<?php

namespace Flasher\Prime\Tests\Filter;

use Notify\Config\Config;
use Notify\Envelope;
use Flasher\Prime\TestsMiddleware\AddCreatedAtStampMiddleware;
use Flasher\Prime\TestsMiddleware\AddPriorityStampMiddleware;
use Flasher\Prime\TestsStamp\PriorityStamp;
use Flasher\Prime\Tests\TestCase;

final class DefaultFilterTest extends TestCase
{
    public function testWithCriteria()
    {
        $notifications = array(
            $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock(),
            $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock(),
        );

        $notifications[3] = new Envelope(
            $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock(),
            array(new PriorityStamp(5))
        );

        $notifications[4] = new Envelope(
            $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock(),
            array(new PriorityStamp(-1))
        );

        $notifications[5] = new Envelope(
            $this->getMockBuilder('Flasher\Prime\TestsNotification\NotificationInterface')->getMock(),
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
