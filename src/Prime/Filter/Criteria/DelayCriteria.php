<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

final class DelayCriteria implements CriteriaInterface
{
    public function __construct(
        private readonly int $minDelay,
        private readonly ?int $maxDelay = null,
    ) {
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn(Envelope $e) => $this->isSatisfiedBy($e));
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $stamp = $envelope->get(DelayStamp::class);

        if (! $stamp instanceof DelayStamp) {
            return false;
        }

        if (null === $this->maxDelay) {
            return $stamp->getDelay() >= $this->minDelay;
        }

        if ($stamp->getDelay() <= $this->maxDelay) {
            return $stamp->getDelay() >= $this->minDelay;
        }

        return false;
    }
}
