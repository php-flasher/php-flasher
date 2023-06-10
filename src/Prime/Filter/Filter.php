<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter;

use Flasher\Prime\Filter\Criteria\CriteriaInterface;
use Flasher\Prime\Notification\Envelope;

final class Filter
{
    /**
     * @var CriteriaInterface[]
     */
    private array $criteriaChain = [];

    /**
     * @param  Envelope[]  $envelopes
     * @return Envelope[]
     */
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
