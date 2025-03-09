<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

/**
 * FilterCriteria - Applies custom closure-based filters to notifications.
 *
 * This criterion allows applying custom filtering logic provided as closures.
 * It's a flexible way to implement complex or specific filtering needs that
 * aren't covered by the standard criteria.
 *
 * Design pattern: Strategy - Encapsulates custom filtering algorithms provided
 * as closures and applies them to notification collections.
 */
final class FilterCriteria implements CriteriaInterface
{
    /**
     * The collection of filter callbacks.
     *
     * @var \Closure[]
     */
    private array $callbacks;

    /**
     * Creates a new FilterCriteria instance.
     *
     * @param mixed $criteria Either a single closure or an array of closures
     *                        Each closure should accept an array of Envelope objects
     *                        and return a filtered array of Envelope objects
     *
     * @throws \InvalidArgumentException If the criteria is not a closure or array of closures
     */
    public function __construct(mixed $criteria)
    {
        if (!$criteria instanceof \Closure && !\is_array($criteria)) {
            throw new \InvalidArgumentException(\sprintf('Invalid type for criteria "filter". Expect a closure or array of closure, got "%s".', get_debug_type($criteria)));
        }

        $criteria = $criteria instanceof \Closure ? [$criteria] : $criteria;
        foreach ($criteria as $callback) {
            if (!$callback instanceof \Closure) {
                throw new \InvalidArgumentException(\sprintf('Each element must be a closure, got got "%s".', get_debug_type($callback)));
            }

            $this->callbacks[] = $callback;
        }
    }

    /**
     * Applies the filter callbacks to the envelopes.
     *
     * Each callback is applied in sequence, with the output of one becoming
     * the input to the next.
     *
     * @param Envelope[] $envelopes The notification envelopes to filter
     *
     * @return Envelope[] The filtered notification envelopes
     */
    public function apply(array $envelopes): array
    {
        foreach ($this->callbacks as $callback) {
            $envelopes = $callback($envelopes);
        }

        return $envelopes;
    }
}
