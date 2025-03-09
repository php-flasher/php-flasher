<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

/**
 * PriorityCriteria - Filters notifications by priority.
 *
 * This criterion filters notification envelopes based on their priority level.
 * It can filter for priorities within a specific range (min to max) or above
 * a minimum threshold.
 *
 * Design pattern: Specification - Defines filter logic based on priority ranges.
 */
final readonly class PriorityCriteria implements CriteriaInterface
{
    use RangeExtractor;

    /**
     * The minimum priority threshold (inclusive).
     */
    private ?int $minPriority;

    /**
     * The maximum priority threshold (inclusive).
     */
    private ?int $maxPriority;

    /**
     * Creates a new PriorityCriteria instance.
     *
     * @param mixed $criteria The priority criteria, either:
     *                        - An integer (minimum priority threshold)
     *                        - An array with 'min' and/or 'max' keys
     *
     * @throws \InvalidArgumentException If the criteria format is invalid
     */
    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minPriority = $criteria['min'];
        $this->maxPriority = $criteria['max'];
    }

    /**
     * Filters envelopes by priority.
     *
     * @param Envelope[] $envelopes The envelopes to filter
     *
     * @return Envelope[] Envelopes that match the priority criteria
     */
    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $envelope): bool => $this->match($envelope));
    }

    /**
     * Checks if an envelope matches the priority criteria.
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope matches the criteria, false otherwise
     */
    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(PriorityStamp::class);

        if (!$stamp instanceof PriorityStamp) {
            return false;
        }

        $priority = $stamp->getPriority();

        if (null === $this->maxPriority) {
            return $priority >= $this->minPriority;
        }

        if ($priority <= $this->maxPriority) {
            return $priority >= $this->minPriority;
        }

        return false;
    }
}
