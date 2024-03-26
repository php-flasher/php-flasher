<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;
use Flasher\Prime\Storage\Filter\Filter;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class FilterTest extends MockeryTestCase
{
    private Filter $filter;

    protected function setUp(): void
    {
        $this->filter = new Filter();
    }

    public function testApply(): void
    {
        $envelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $expectedEnvelopes = [
            new Envelope(new Notification(), new IdStamp('1111')),
            new Envelope(new Notification(), new IdStamp('2222')),
        ];

        $criteria = \Mockery::mock(CriteriaInterface::class);
        $criteria->allows()
            ->apply($envelopes)
            ->andReturns($expectedEnvelopes);

        $this->filter->addCriteria($criteria);

        $this->assertSame($expectedEnvelopes, $this->filter->apply($envelopes));
    }

    public function testAddCriteria(): void
    {
        $criteria = \Mockery::mock(CriteriaInterface::class);

        $this->filter->addCriteria($criteria);

        $reflection = new \ReflectionClass($this->filter);
        $property = $reflection->getProperty('criteriaChain');

        /** @var CriteriaInterface[] $criteriaChain */
        $criteriaChain = $property->getValue($this->filter);

        $this->assertContains($criteria, $criteriaChain);
    }
}
