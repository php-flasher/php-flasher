<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;

final readonly class LimitCriteria implements CriteriaInterface
{
    private int $limit;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(mixed $criteria)
    {
        if (!\is_int($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'limit'.");
        }

        if ($criteria < 1) {
            throw new \InvalidArgumentException("Criteria 'limit' must be a positive integer (>= 1).");
        }

        $this->limit = $criteria;
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     */
    public function apply(array $envelopes): array
    {
        return \array_slice($envelopes, 0, $this->limit, true);
    }
}
