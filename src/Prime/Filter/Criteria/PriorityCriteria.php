<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

final class PriorityCriteria implements CriteriaInterface
{
    public function __construct(
        private readonly ?int $minPriority,
        private readonly ?int $maxPriority = null
    ) {
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e) => $this->isSatisfiedBy($e));
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $stamp = $envelope->get(PriorityStamp::class);

        if (! $stamp instanceof PriorityStamp) {
            return false;
        }

        if (null === $this->maxPriority) {
            return $stamp->getPriority() >= $this->minPriority;
        }

        if ($stamp->getPriority() <= $this->maxPriority) {
            return $stamp->getPriority() >= $this->minPriority;
        }

        return false;
    }
}
