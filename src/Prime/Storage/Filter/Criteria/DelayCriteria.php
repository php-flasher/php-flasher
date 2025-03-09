<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

/**
 * DelayCriteria - Filters notifications by delay time.
 *
 * This criterion filters notification envelopes based on their delay time,
 * which determines how long to wait before displaying a notification.
 * It can filter for delays within a specific range (min to max) or above a minimum.
 *
 * Design pattern: Specification - Defines filter logic based on delay ranges.
 */
final readonly class DelayCriteria implements CriteriaInterface
{
    use RangeExtractor;

    /**
     * The minimum delay time in milliseconds (inclusive).
     */
    private ?int $minDelay;

    /**
     * The maximum delay time in milliseconds (inclusive).
     */
    private ?int $maxDelay;

    /**
     * Creates a new DelayCriteria instance.
     *
     * @param mixed $criteria The delay criteria, either:
     *                        - An integer (minimum delay threshold)
     *                        - An array with 'min' and/or 'max' keys
     *
     * @throws \InvalidArgumentException If the criteria format is invalid
     */
    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minDelay = $criteria['min'];
        $this->maxDelay = $criteria['max'];
    }

    /**
     * Filters envelopes by delay time.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] Envelopes that match the delay criteria
     */
    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $envelope): bool => $this->match($envelope));
    }

    /**
     * Checks if an envelope matches the delay criteria.
     *
     * @param Envelope $envelope The envelope to check
     *
     * @return bool True if the envelope matches the criteria, false otherwise
     */
    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(DelayStamp::class);

        if (!$stamp instanceof DelayStamp) {
            return false;
        }

        $delay = $stamp->getDelay();

        if (null === $this->maxDelay) {
            return $delay >= $this->minDelay;
        }

        if ($delay <= $this->maxDelay) {
            return $delay >= $this->minDelay;
        }

        return false;
    }
}
