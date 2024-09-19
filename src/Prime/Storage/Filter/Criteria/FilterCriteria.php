<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

final class FilterCriteria implements CriteriaInterface
{
    /**
     * @var \Closure[]
     */
    private array $callbacks;

    /**
     * @throws \InvalidArgumentException if the criteria type is invalid
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
     */
    public function apply(array $envelopes): array
    {
        foreach ($this->callbacks as $callback) {
            $envelopes = $callback($envelopes);
        }

        return $envelopes;
    }
}
