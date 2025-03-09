<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

/**
 * LimitCriteria - Limits the number of notifications returned.
 *
 * This criterion doesn't filter based on notification content but instead
 * limits the total number of notifications in the result set. It's useful
 * for pagination or enforcing display limits.
 *
 * Design pattern: Specification - Defines filter logic based on result count.
 */
final readonly class LimitCriteria implements CriteriaInterface
{
    /**
     * The maximum number of notifications to return.
     */
    private int $limit;

    /**
     * Creates a new LimitCriteria instance.
     *
     * @param mixed $criteria The maximum number of notifications to return
     *
     * @throws \InvalidArgumentException If the criteria is not an integer
     */
    public function __construct(mixed $criteria)
    {
        if (!\is_int($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'limit'.");
        }

        $this->limit = $criteria;
    }

    /**
     * Limits the number of envelopes in the result set.
     *
     * @param Envelope[] $envelopes The notification envelopes to limit
     *
     * @return Envelope[] The limited set of notification envelopes
     */
    public function apply(array $envelopes): array
    {
        return \array_slice($envelopes, 0, $this->limit, true);
    }
}
