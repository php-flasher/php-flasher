<?php

namespace Flasher\Prime\Tests\Filter;

use Flasher\Prime\Filter\CriteriaBuilder;
use Flasher\Prime\Filter\FilterBuilder;
use Flasher\Prime\Tests\TestCase;

final class CriteriaBuilderTest extends TestCase
{
    public function testCriteria()
    {
        $criteria = new CriteriaBuilder(new FilterBuilder(), array(
            'priority' => 1,
            'life' => 2,
            'limit' => 2,
            'order_by' => 'Flasher\Prime\Stamp\HopsStamp',
        ));

        $this->assertInstanceOf('Flasher\Prime\Filter\FilterBuilder', $criteria->build());
        $this->assertNotEmpty($criteria->build()->getSpecification());
    }

    public function testWithoutPriority()
    {
        $criteria = new CriteriaBuilder(new FilterBuilder(), array());

        $this->assertInstanceOf('Flasher\Prime\Filter\FilterBuilder', $criteria->build());
        $this->assertEmpty($criteria->build()->getSpecification());
    }
}
