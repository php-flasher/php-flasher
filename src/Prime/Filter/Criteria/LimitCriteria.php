<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

class LimitCriteria implements CriteriaInterface
{
    public function __construct(private readonly int $limit)
    {
    }

    public function apply(array $envelopes): array
    {
        return \array_slice($envelopes, 0, $this->limit, true);
    }
}
