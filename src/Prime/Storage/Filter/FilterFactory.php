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

/**
 * FilterFactory - Creates and configures filter instances.
 *
 * This class is responsible for creating filter instances with the appropriate
 * criteria based on configuration. It maintains a registry of available criteria
 * implementations that can be used to build filters.
 *
 * Design patterns:
 * - Factory: Creates and configures filters based on configuration
 * - Registry: Maintains a collection of available criteria implementations
 */
final class FilterFactory implements FilterFactoryInterface
{
    /**
     * Registry of available criteria implementations.
     *
     * @var array<string, callable|CriteriaInterface>
     */
    private array $criteria = [];

    /**
     * Creates a new FilterFactory instance with default criteria.
     *
     * This constructor registers all the standard criteria types that can
     * be used for filtering notifications.
     */
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

    /**
     * Creates a filter based on the provided configuration.
     *
     * This method creates a new filter and adds criteria to it based on
     * the provided configuration keys and values.
     *
     * @param array<string, mixed> $config Configuration for the filter criteria
     *
     * @return Filter The created filter with configured criteria
     *
     * @throws CriteriaNotRegisteredException If a requested criterion doesn't exist
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

    /**
     * Registers a new criterion implementation.
     *
     * This method allows adding custom criteria to the factory. The criterion
     * can be provided either as an instance or as a factory callback.
     *
     * @param string                     $name     The name of the criterion
     * @param callable|CriteriaInterface $criteria The criterion implementation or factory
     */
    public function addCriteria(string $name, callable|CriteriaInterface $criteria): void
    {
        $this->criteria[$name] = $criteria;
    }

    /**
     * Internal helper to create a criterion instance.
     *
     * This method looks up the requested criterion by name and creates an
     * instance with the provided value.
     *
     * @param string $name  The name of the criterion
     * @param mixed  $value The configuration value for the criterion
     *
     * @return CriteriaInterface The created criterion instance
     *
     * @throws CriteriaNotRegisteredException If the requested criterion doesn't exist
     * @throws \UnexpectedValueException      If the factory doesn't return a CriteriaInterface
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
