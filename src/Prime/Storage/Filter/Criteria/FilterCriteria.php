<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

class FilterCriteria implements CriteriaInterface
{
    private $callbacks = [];

    public function __construct(mixed $criteria)
    {
        if (! is_callable($criteria) && ! is_array($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'filter'.");
        }

        $this->callbacks = $criteria;
    }

    public function apply(array $envelopes): array
    {
        // TODO: Implement apply() method.
    }
}
