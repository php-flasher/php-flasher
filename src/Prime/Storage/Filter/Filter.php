<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;

/**
 * Filter - Default implementation of the filter interface.
 *
 * This class implements a chain of filtering criteria that are applied in sequence
 * to notification envelopes. Each criterion refines the set of envelopes further.
 *
 * Design pattern: Chain of Responsibility - Each criterion in the chain has a chance
 * to process the envelopes, potentially filtering some out, before passing to the next.
 */
final class Filter implements FilterInterface
{
    /**
     * The chain of filtering criteria.
     *
     * @var CriteriaInterface[]
     */
    private array $criteriaChain = [];

    /**
     * Applies the filter to an array of notification envelopes.
     *
     * This method applies each criterion in the chain sequentially,
     * passing the results from one to the next.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] The filtered notification envelopes
     */
    public function apply(array $envelopes): array
    {
        foreach ($this->criteriaChain as $criteria) {
            $envelopes = $criteria->apply($envelopes);
        }

        return $envelopes;
    }

    /**
     * Adds a criterion to the filter chain.
     *
     * Each added criterion will be applied in the order they were added.
     *
     * @param CriteriaInterface $criteria The criterion to add
     */
    public function addCriteria(CriteriaInterface $criteria): void
    {
        $this->criteriaChain[] = $criteria;
    }
}
