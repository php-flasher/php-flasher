<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;

final class Filter implements FilterInterface
{
    /**
     * @var CriteriaInterface[]
     */
    private array $criteriaChain = [];

    public function apply(array $envelopes): array
    {
        foreach ($this->criteriaChain as $criteria) {
            $envelopes = $criteria->apply($envelopes);
        }

        return $envelopes;
    }

    public function addCriteria(CriteriaInterface $criteria): void
    {
        $this->criteriaChain[] = $criteria;
    }
}
