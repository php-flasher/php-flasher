<?php

namespace Flasher\Tests\Prime\Filter;

use Flasher\Prime\Filter\CriteriaBuilder;
use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Tests\Prime\TestCase;

class CriteriaBuilderTest extends TestCase
{
    /**
     * @return void
     */
    public function testItAddsPrioritySpecification()
    {
        $filter = $this->getFilter();
        $criteria = ['priority' => 2];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildPriority();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf('Flasher\Prime\Filter\Specification\PrioritySpecification', $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minPriority'));
        $this->assertNull($this->getProperty($specification, 'maxPriority'));
    }

    /**
     * @return void
     */
    public function testItAddsHopsSpecification()
    {
        $filter = $this->getFilter();
        $criteria = ['hops' => 2];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildHops();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf('Flasher\Prime\Filter\Specification\HopsSpecification', $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minAmount'));
        $this->assertNull($this->getProperty($specification, 'maxAmount'));
    }

    /**
     * @return void
     */
    public function testItAddsDelaySpecification()
    {
        $filter = $this->getFilter();
        $criteria = ['delay' => 2];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildDelay();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf('Flasher\Prime\Filter\Specification\DelaySpecification', $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minDelay'));
        $this->assertNull($this->getProperty($specification, 'maxDelay'));
    }

    /**
     * @return void
     */
    public function testItAddsLifeSpecification()
    {
        $filter = $this->getFilter();
        $criteria = ['life' => 2];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildLife();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf('Flasher\Prime\Filter\Specification\HopsSpecification', $specification);
        $this->assertEquals(2, $this->getProperty($specification, 'minAmount'));
        $this->assertNull($this->getProperty($specification, 'maxAmount'));
    }

    /**
     * @return void
     */
    public function testItAddsOrdering()
    {
        $filter = $this->getFilter();
        $criteria = ['order_by' => 'priority'];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildOrder();

        $orderings = $this->getProperty($filter, 'orderings');

        $this->assertEquals(["Flasher\Prime\Stamp\PriorityStamp" => 'ASC'], $orderings);
    }

    /**
     * @return void
     */
    public function testItFilterEnvelopesByStamps()
    {
        $filter = $this->getFilter();
        $criteria = ['stamps' => 'preset'];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildStamps();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf('Flasher\Prime\Filter\Specification\StampsSpecification', $specification);
        $this->assertEquals(['Flasher\Prime\Stamp\PresetStamp'], $this->getProperty($specification, 'stamps'));
        $this->assertEquals('or', $this->getProperty($specification, 'strategy'));
    }

    /**
     * @return void
     */
    public function testItFilterEnvelopesByCallbacks()
    {
        $callback = function () {};
        $filter = $this->getFilter();
        $criteria = ['filter' => $callback];

        $criteriaBuilder = new CriteriaBuilder($filter, $criteria);
        $criteriaBuilder->buildCallback();

        $specification = $this->getProperty($filter, 'specification');

        $this->assertInstanceOf('Flasher\Prime\Filter\Specification\CallbackSpecification', $specification);
        $this->assertEquals($filter, $this->getProperty($specification, 'filter'));
        $this->assertEquals($callback, $this->getProperty($specification, 'callback'));
    }

    /**
     * @return Filter
     */
    private function getFilter()
    {
        $envelopes = [];

        $notification = new Notification();
        $notification->setMessage('success message');
        $notification->setTitle('PHPFlasher');
        $notification->setType('success');
        $envelopes[] = new Envelope($notification, [
            new CreatedAtStamp(new \DateTime('2023-02-05 16:22:50')),
            new UuidStamp('1111'),
            new PriorityStamp(1),
            new PresetStamp('entity_saved'),
        ]);

        $notification = new Notification();
        $notification->setMessage('warning message');
        $notification->setTitle('yoeunes/toastr');
        $notification->setType('warning');
        $envelopes[] = new Envelope($notification, [
            new CreatedAtStamp(new \DateTime('2023-02-06 16:22:50')),
            new UuidStamp('2222'),
            new PriorityStamp(3),
        ]);

        return new Filter($envelopes, []);
    }
}
