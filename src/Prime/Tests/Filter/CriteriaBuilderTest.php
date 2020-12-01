<?php

namespace Flasher\Prime\Tests\Filter;

use Flasher\Prime\TestsFilter\CriteriaBuilder;
use Flasher\Prime\TestsFilter\FilterBuilder;
use Flasher\Prime\Tests\TestCase;

final class CriteriaBuilderTest extends TestCase
{
    public function testCriteria()
    {
        $criteria = new CriteriaBuilder(
            new FilterBuilder(), array(
            'priority' => 1,
            'life'     => 2,
            'limit'    => 2,
            'order_by' => 'Flasher\Prime\TestsStamp\ReplayStamp',
        )
        );

        $this->assertInstanceOf('Flasher\Prime\TestsFilter\FilterBuilder', $criteria->build());
        $this->assertNotEmpty($criteria->build()->getSpecification());
    }

    public function testWithoutPriority()
    {
        $criteria = new CriteriaBuilder(new FilterBuilder(), array());

        $this->assertInstanceOf('Flasher\Prime\TestsFilter\FilterBuilder', $criteria->build());
        $this->assertEmpty($criteria->build()->getSpecification());
    }
}
