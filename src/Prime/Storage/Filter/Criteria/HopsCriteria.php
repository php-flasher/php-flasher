<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

/**
 * HopsCriteria - Filters notifications by hops count.
 *
 * This criterion filters notification envelopes based on their hops count,
 * which determines how many requests/redirects a notification should persist for.
 * It can filter for hops within a specific range (min to max) or above a minimum.
 *
 * Design pattern: Specification - Defines filter logic based on hops ranges.
 */
final readonly class HopsCriteria implements CriteriaInterface
{
    use RangeExtractor;

    /**
     * The minimum hops amount (inclusive).
     */
    private readonly ?int $minAmount;

    /**
     * The maximum hops amount (inclusive).
     */
    private readonly ?int $maxAmount;

    /**
     * Creates a new HopsCriteria instance.
     *
     * @param mixed $criteria The hops criteria, either:
     *                        - An integer (minimum hops threshold)
     *                        - An array with 'min' and/or 'max' keys
     *
     * @throws \InvalidArgumentException If the criteria format is invalid
     */
    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minAmount = $criteria['min'];
        $this->maxAmount = $criteria['max'];
    }

    /**
     * Filters envelopes by hops count.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] Envelopes that match the hops criteria
     */
    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e): bool => $this->match($e));
    }

    /**
     * Checks if an envelope matches the hops criteria.
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope matches the criteria, false otherwise
     */
    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(HopsStamp::class);

        if (!$stamp instanceof HopsStamp) {
            return false;
        }

        if (null === $this->maxAmount) {
            return $stamp->getAmount() >= $this->minAmount;
        }

        if ($stamp->getAmount() <= $this->maxAmount) {
            return $stamp->getAmount() >= $this->minAmount;
        }

        return false;
    }
}
