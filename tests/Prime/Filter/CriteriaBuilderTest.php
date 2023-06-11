<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Filter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Storage\Filter\Filter;
use Flasher\Prime\Storage\Filter\FilterFactory;
use Flasher\Tests\Prime\TestCase;

final class CriteriaBuilderTest extends TestCase
{
    public function testItAddsPrioritySpecification(): void
    {
        $filter = $this->getFilter();
        $criteria = ['priority' => 2];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getPriority();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf(\Flasher\Prime\Filter\Specification\PrioritySpecification::class, $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minPriority'));
        $this->assertNull($this->getProperty($specification, 'maxPriority'));
    }

    public function testItAddsHopsSpecification(): void
    {
        $filter = $this->getFilter();
        $criteria = ['hops' => 2];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getHops();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf(
            \Flasher\Prime\Storage\Filter\Criteria\HopsCriteria::class, $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minAmount'));
        $this->assertNull($this->getProperty($specification, 'maxAmount'));
    }

    public function testItAddsDelaySpecification(): void
    {
        $filter = $this->getFilter();
        $criteria = ['delay' => 2];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getDelay();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf(
            \Flasher\Prime\Storage\Filter\Criteria\DelayCriteria::class, $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minDelay'));
        $this->assertNull($this->getProperty($specification, 'maxDelay'));
    }

    public function testItAddsLifeSpecification(): void
    {
        $filter = $this->getFilter();
        $criteria = ['life' => 2];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getLife();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf(
            \Flasher\Prime\Storage\Filter\Criteria\HopsCriteria::class, $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minAmount'));
        $this->assertNull($this->getProperty($specification, 'maxAmount'));
    }

    public function testItAddsOrdering(): void
    {
        $filter = $this->getFilter();
        $criteria = ['order_by' => 'priority'];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getOrderBy();

        $orderings = $this->getProperty($filter, 'orderings');

        $this->assertEquals([\Flasher\Prime\Stamp\PriorityStamp::class => 'ASC'], $orderings);
    }

    public function testItFilterEnvelopesByStamps(): void
    {
        $filter = $this->getFilter();
        $criteria = ['stamps' => 'preset'];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getStamps();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf(
            \Flasher\Prime\Storage\Filter\Criteria\StampsCriteria::class, $specification);
        $this->assertEquals([\Flasher\Prime\Stamp\PresetStamp::class], $this->getProperty($specification, 'stamps'));
        $this->assertEquals('or', $this->getProperty($specification, 'strategy'));
    }

    public function testItFilterEnvelopesByCallbacks(): void
    {
        $callback = static function (): void {
        };
        $filter = $this->getFilter();
        $criteria = ['filter' => $callback];

        $criteriaBuilder = new FilterFactory($filter, $criteria);
        $criteriaBuilder->getCallback();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf(\Flasher\Prime\Filter\Specification\CallbackSpecification::class, $specification);
        $this->assertEquals($filter, $this->getProperty($specification, 'filter'));
        $this->assertEquals($callback, $this->getProperty($specification, 'callback'));
    }

    private function getFilter(): Filter
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, [
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new IdStamp('1111'),
            new PriorityStamp(1),
            new PresetStamp('entity_saved'),
        ]);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, [
            new CreatedAtStamp(new \DateTime('2023-02-06 16:22:50')),
            new IdStamp('2222'),
            new PriorityStamp(3),
        ]);

        return new Filter($envelopes, []);
    }
}
