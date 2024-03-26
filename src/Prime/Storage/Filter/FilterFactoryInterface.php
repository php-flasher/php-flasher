<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Exception\CriteriaNotRegisteredException;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;

interface FilterFactoryInterface
{
    /**
     * @param array<string, mixed> $config
     *
     * @throws CriteriaNotRegisteredException
     */
    public function createFilter(array $config): Filter;

    public function addCriteria(string $name, callable|CriteriaInterface $criteria): void;
}
