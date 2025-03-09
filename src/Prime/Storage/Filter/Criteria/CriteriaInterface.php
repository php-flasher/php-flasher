<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

/**
 * CriteriaInterface - Contract for notification filtering criteria.
 *
 * This interface defines the essential operation for filtering notification
 * envelopes based on specific criteria. Each implementation defines its own
 * logic for determining which envelopes match the criteria.
 *
 * Design pattern: Specification - Defines a clear, boolean-logic based way
 * to check if an object satisfies some criteria.
 */
interface CriteriaInterface
{
    /**
     * Applies the criterion to filter notification envelopes.
     *
     * This method should analyze the provided envelopes and return
     * only those that match the criterion's conditions.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] The filtered notification envelopes
     */
    public function apply(array $envelopes): array;
}
