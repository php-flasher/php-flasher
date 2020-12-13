<?php

namespace Flasher\Prime\Tests\Filter;

use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\FilterBuilder;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Tests\TestCase;

final class FilterBuilderTest extends TestCase
{
    public function testEmptyFilter()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $builder = new FilterBuilder();

        $filtered = $builder->filter($envelopes);
        $expected = $envelopes;

        $this->assertEquals($expected, $filtered);
    }

    public function testMaxResults()
    {
        $envelopes = array(
            new Envelope(new Notification()),
            new Envelope(new Notification()),
            new Envelope(new Notification()),
        );

        $builder = new FilterBuilder();
        $builder->setMaxResults(2);

        $filtered = $builder->filter($envelopes);
        $expected = array_slice($envelopes, 0, 2);

        $this->assertEquals($expected, $filtered);
    }

    public function testOrderingByPriority()
    {
        $envelopes = array(
            0 => new Envelope(new Notification(), array(
                new PriorityStamp(5),
                new CreatedAtStamp(),
            )),
            1 => new Envelope(new Notification(), array(
                new PriorityStamp(4),
            )),
            2 => new Envelope(new Notification(), array(
                new PriorityStamp(-2),
            )),
            3 => new Envelope(new Notification(), array(
                new CreatedAtStamp(),
            )),
            4 => new Envelope(new Notification(), array(
                new PriorityStamp(7),
            )),
            5 => new Envelope(new Notification(), array(
                new PriorityStamp(6),
            )),
            6 => new Envelope(new Notification(), array(
                new PriorityStamp(-1),
            )),
        );

        $builder = new FilterBuilder();
        $builder->orderBy(array(
            'Flasher\Prime\Stamp\PriorityStamp' => FilterBuilder::ASC,
        ));

        $filtered = $builder->filter($envelopes);
        $expected = array(
            $envelopes[3],
            $envelopes[2],
            $envelopes[6],
            $envelopes[1],
            $envelopes[0],
            $envelopes[5],
            $envelopes[4],
        );

        $this->assertEquals($expected, $filtered);
    }
}
