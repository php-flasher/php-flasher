<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

final class FilterCriteria implements CriteriaInterface
{
    /**
     * @var \Closure[]
     */
    private array $callbacks = [];

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(mixed $criteria)
    {
        if (!$criteria instanceof \Closure && !\is_array($criteria)) {
            throw new \InvalidArgumentException(\sprintf('Invalid type for criteria "filter". Expect a closure or array of closure, got "%s".', get_debug_type($criteria)));
        }

        $criteria = $criteria instanceof \Closure ? [$criteria] : $criteria;
        foreach ($criteria as $callback) {
            if (!$callback instanceof \Closure) {
                throw new \InvalidArgumentException(\sprintf('Each element must be a closure, got "%s".', get_debug_type($callback)));
            }

            $this->callbacks[] = $callback;
        }
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     *
     * @throws \InvalidArgumentException
     */
    public function apply(array $envelopes): array
    {
        foreach ($this->callbacks as $callback) {
            $result = $callback($envelopes);

            if (!\is_array($result)) {
                throw new \InvalidArgumentException(\sprintf('Filter callback must return an array, got "%s".', get_debug_type($result)));
            }

            /** @var Envelope[] $result */
            $envelopes = $result;
        }

        return $envelopes;
    }
}
