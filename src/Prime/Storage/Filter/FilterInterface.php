<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;

/**
 * FilterInterface - Contract for notification envelope filters.
 *
 * This interface defines the essential operations for filtering notification
 * envelopes. It allows composing multiple criteria into a single filter chain.
 *
 * Design pattern: Chain of Responsibility - Allows chaining multiple filtering
 * criteria that are applied in sequence.
 */
interface FilterInterface
{
    /**
     * Applies the filter to an array of notification envelopes.
     *
     * This method should filter the provided envelopes according to
     * the filter's criteria and return the matching subset.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] The filtered notification envelopes
     */
    public function apply(array $envelopes): array;

    /**
     * Adds a criterion to the filter chain.
     *
     * This method should add the provided criterion to the filter,
     * extending its filtering capabilities.
     *
     * @param CriteriaInterface $criteria The criterion to add
     */
    public function addCriteria(CriteriaInterface $criteria): void;
}
