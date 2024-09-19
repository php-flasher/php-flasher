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
use Flasher\Prime\Storage\Filter\Criteria\PresenterCriteria;
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
        $criteriaClasses = [
            'priority' => PriorityCriteria::class,
            'hops' => HopsCriteria::class,
            'delay' => DelayCriteria::class,
            'order_by' => OrderByCriteria::class,
            'limit' => LimitCriteria::class,
            'stamps' => StampsCriteria::class,
            'filter' => FilterCriteria::class,
            'presenter' => PresenterCriteria::class,
        ];

        foreach ($criteriaClasses as $name => $criteriaClass) {
            $this->addCriteria($name, fn (mixed $criteria) => new $criteriaClass($criteria));
        }
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
        $criteria = \is_callable($criteria) ? $criteria($value) : $criteria;

        if (!$criteria instanceof CriteriaInterface) {
            throw new \UnexpectedValueException(\sprintf('Expected an instance of "%s", got "%s" instead.', CriteriaInterface::class, get_debug_type($criteria)));
        }

        return $criteria;
    }
}
