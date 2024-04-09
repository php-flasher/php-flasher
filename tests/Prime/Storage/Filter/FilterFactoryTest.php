<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Storage\Filter;

use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;
use Flasher\Prime\Storage\Filter\Criteria\LimitCriteria;
use Flasher\Prime\Storage\Filter\Filter;
use Flasher\Prime\Storage\Filter\FilterFactory;
use PHPUnit\Framework\TestCase;

final class FilterFactoryTest extends TestCase
{
    private FilterFactory $filterFactory;

    protected function setUp(): void
    {
        $this->filterFactory = new FilterFactory();
    }

    public function testConstructor(): void
    {
        $reflect = new \ReflectionClass(FilterFactory::class);
        $reflectValue = $reflect->getProperty('criteria');

        /** @var array<string, CriteriaInterface> $value */
        $value = $reflectValue->getValue($this->filterFactory);

        $this->assertArrayHasKey('priority', $value);
        $this->assertArrayHasKey('hops', $value);
        $this->assertArrayHasKey('delay', $value);
        $this->assertArrayHasKey('order_by', $value);
        $this->assertArrayHasKey('limit', $value);
        $this->assertArrayHasKey('stamps', $value);
        $this->assertArrayHasKey('filter', $value);
        $this->assertArrayHasKey('presenter', $value);
    }

    public function testCreateFilter(): void
    {
        $config = [
            'limit' => 5,
        ];

        $filter = $this->filterFactory->createFilter($config);

        $reflect = new \ReflectionClass(Filter::class);
        $reflectValue = $reflect->getProperty('criteriaChain');

        /** @var CriteriaInterface[] $value */
        $value = $reflectValue->getValue($filter);

        $this->assertInstanceOf(LimitCriteria::class, $value[0]);
    }

    public function testCreateFilterWithInvalidCriteriaName(): void
    {
        $this->expectException(CriteriaNotRegisteredException::class);

        $config = ['invalid_criteria_name' => 'invalid_criteria_value'];
        $this->filterFactory->createFilter($config);
    }

    public function testAddCriteria(): void
    {
        $reflect = new \ReflectionClass(FilterFactory::class);
        $reflectValue = $reflect->getProperty('criteria');

        $this->filterFactory->addCriteria('custom_criteria', fn () => new class() implements CriteriaInterface {
            public function apply(array $envelopes): array
            {
                return $envelopes;
            }
        });

        /** @var array<string, \Closure> $value */
        $value = $reflectValue->getValue($this->filterFactory);

        $this->assertArrayHasKey('custom_criteria', $value);
    }
}
