<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;
use Flasher\Prime\Storage\Filter\Criteria\DelayCriteria;
use Flasher\Prime\Storage\Filter\Criteria\FilterCriteria;
use Flasher\Prime\Storage\Filter\Criteria\HopsCriteria;
use Flasher\Prime\Storage\Filter\Criteria\LimitCriteria;
use Flasher\Prime\Storage\Filter\Criteria\OrderByCriteria;
use Flasher\Prime\Storage\Filter\Criteria\PriorityCriteria;
use Flasher\Prime\Storage\Filter\Criteria\StampsCriteria;

final class FilterFactory implements FilterFactoryInterface
{
    /**
     * @var array<string, callable|CriteriaInterface>
     */
    private array $criteria = [];

    public function __construct()
    {
        $this->addCriteria('priority', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\PriorityCriteria => new PriorityCriteria($criteria));
        $this->addCriteria('hops', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\HopsCriteria => new HopsCriteria($criteria));
        $this->addCriteria('delay', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\DelayCriteria => new DelayCriteria($criteria));
        $this->addCriteria('order_by', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\OrderByCriteria => new OrderByCriteria($criteria));
        $this->addCriteria('limit', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\LimitCriteria => new LimitCriteria($criteria));
        $this->addCriteria('stamps', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\StampsCriteria => new StampsCriteria($criteria));
        $this->addCriteria('filter', static fn (mixed $criteria): \Flasher\Prime\Storage\Filter\Criteria\FilterCriteria => new FilterCriteria($criteria));
    }

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
     * @throws CriteriaNotRegisteredException
     */
    private function createCriteria(string $name, mixed $value): CriteriaInterface
    {
        if (!isset($this->criteria[$name])) {
            throw CriteriaNotRegisteredException::create($name, array_keys($this->criteria));
        }

        $criteria = $this->criteria[$name];
        $criteria = is_callable($criteria) ? $criteria($value) : $criteria;

        if (!$criteria instanceof CriteriaInterface) {
            throw new \UnexpectedValueException(sprintf('Expected an instance of "%s", got "%s" instead.', CriteriaInterface::class, get_debug_type($criteria)));
        }

        return $criteria;
    }
}
