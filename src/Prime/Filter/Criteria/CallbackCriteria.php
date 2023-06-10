<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

class CallbackCriteria implements CriteriaInterface
{
    /**
     * @param callable[] $callbacks
     */
    public function __construct(private readonly array $callbacks)
    {
    }

    public function apply(array $envelopes): array
    {
        // TODO: Implement apply() method.
    }
}
