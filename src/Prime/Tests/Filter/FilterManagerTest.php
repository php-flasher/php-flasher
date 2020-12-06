<?php

namespace Flasher\Prime\Tests\Filter;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\FilterBuilder;
use Flasher\Prime\Filter\Specification\PrioritySpecification;
use Flasher\Prime\Middleware\AddCreatedAtStampMiddleware;
use Flasher\Prime\Middleware\AddPriorityStampMiddleware;
use Flasher\Prime\Middleware\FlasherBus;
use Flasher\Prime\Stamp\PriorityStamp;
use PHPUnit\Framework\TestCase;

final class FilterManagerTest extends TestCase
{
    public function testFilterWhere()
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

        $middleware = new FlasherBus($config);

        $envelopes = array();
        foreach ($notifications as $notification) {
            $envelopes[] = $middleware->dispatch($notification);
        }

        $builder = new FilterBuilder();

        $envelopes = $builder
            ->andWhere(new PrioritySpecification(1))
            ->andWhere(new PrioritySpecification(1, 5))
            ->orderBy(
                array(
                    'Flasher\Prime\Stamp\PriorityStamp' => 'ASC'
                )
            )
            ->setMaxResults(2)
            ->filter($envelopes);

        $this->assertNotEmpty($envelopes);

        $builder = new FilterBuilder();

        $envelopes = $builder
            ->orWhere(new PrioritySpecification(1))
            ->orWhere(new PrioritySpecification(1, 5))
            ->orderBy(
                array(
                    'Flasher\Prime\Stamp\PriorityStamp'      => 'ASC',
                    'Flasher\Prime\Envelope\Stamp\NotExists' => 'ASC',
                )
            )
            ->setMaxResults(2)
            ->filter($envelopes);

        $this->assertNotEmpty($envelopes);

        $builder = new FilterBuilder();
        $builder->withCriteria(
            array(
                'priority' => '1'
            )
        );

        $envelopes = $builder->filter($envelopes);
        $this->assertNotEmpty($envelopes);
    }
}
