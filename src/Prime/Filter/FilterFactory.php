<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use Flasher\Prime\Filter\Criteria\CriteriaInterface;
use Flasher\Prime\Filter\Criteria\DelayCriteria;
use Flasher\Prime\Filter\Criteria\FilterCriteria;
use Flasher\Prime\Filter\Criteria\HopsCriteria;
use Flasher\Prime\Filter\Criteria\LimitCriteria;
use Flasher\Prime\Filter\Criteria\OrderByCriteria;
use Flasher\Prime\Filter\Criteria\PriorityCriteria;
use Flasher\Prime\Filter\Criteria\StampsCriteria;

final class FilterFactory
{
    /**
     * @var array<string, callable|CriteriaInterface>
     */
    private array $criteria = [];

    public function __construct()
    {
        $this->addCriteria('priority', fn (mixed $criteria) => new PriorityCriteria($criteria));
        $this->addCriteria('hops', fn (mixed $criteria) => new HopsCriteria($criteria));
        $this->addCriteria('delay', fn (mixed $criteria) => new DelayCriteria($criteria));
        $this->addCriteria('order_by', fn (mixed $criteria) => new OrderByCriteria($criteria));
        $this->addCriteria('limit', fn (mixed $criteria) => new LimitCriteria($criteria));
        $this->addCriteria('stamps', fn (mixed $criteria) => new StampsCriteria($criteria));
        $this->addCriteria('filter', fn (mixed $criteria) => new FilterCriteria($criteria));
    }

    /**
     * @param  array<string, mixed>  $config
     *
     * @throws \Flasher\Prime\Exception\CriteriaNotRegisteredException
     */
    public function createFilter(array $config): Filter
    {
        $filter = new Filter();

        foreach ($config as $name => $value) {
            $criteria = $this->createCriteria($name, $value);

            $filter->addCriteria($criteria);
        }

        return $filter;
    }

    public function addCriteria(string $name, callable|CriteriaInterface $criteria): void
    {
        $this->criteria[$name] = $criteria;
    }

    /**
     * @throws \Flasher\Prime\Exception\CriteriaNotRegisteredException
     */
    private function createCriteria(string $name, mixed $value): CriteriaInterface
    {
        if (! isset($this->criteria[$name])) {
            throw new CriteriaNotRegisteredException($name, array_keys($this->criteria));
        }

        $criteria = $this->criteria[$name];

        $criteria = is_callable($criteria) ? $criteria($value) : $criteria;

        if (! $criteria instanceof CriteriaInterface) {
            throw new \UnexpectedValueException(sprintf('Expected an instance of "%s", got "%s" instead.', CriteriaInterface::class, get_debug_type($criteria)));
        }

        return $criteria;
    }
}
