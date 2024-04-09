<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

final readonly class LimitCriteria implements CriteriaInterface
{
    private int $limit;

    public function __construct(mixed $criteria)
    {
        if (!\is_int($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'limit'.");
        }

        $this->limit = $criteria;
    }

    public function apply(array $envelopes): array
    {
        return \array_slice($envelopes, 0, $this->limit, true);
    }
}
