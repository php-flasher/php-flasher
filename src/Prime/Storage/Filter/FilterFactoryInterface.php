<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;

/**
 * FilterFactoryInterface - Contract for creating filter instances.
 *
 * This interface defines the operations required for a filter factory,
 * which is responsible for creating and configuring filter instances
 * based on provided configuration.
 *
 * Design pattern: Abstract Factory - Defines an interface for creating
 * filter objects without specifying their concrete classes.
 */
interface FilterFactoryInterface
{
    /**
     * Creates a filter based on the provided configuration.
     *
     * @param array<string, mixed> $config Configuration for the filter criteria
     *
     * @return Filter The created filter with configured criteria
     *
     * @throws CriteriaNotRegisteredException If a requested criterion doesn't exist
     */
    public function createFilter(array $config): Filter;

    /**
     * Registers a new criterion implementation.
     *
     * @param string                     $name     The name of the criterion
     * @param callable|CriteriaInterface $criteria The criterion implementation or factory
     */
    public function addCriteria(string $name, callable|CriteriaInterface $criteria): void;
}
