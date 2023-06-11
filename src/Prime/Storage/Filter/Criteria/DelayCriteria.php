<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

final class DelayCriteria implements CriteriaInterface
{
    use ExtractRange;

    private ?int $minDelay;

    private ?int $maxDelay;

    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minDelay = $criteria['min'];
        $this->maxDelay = $criteria['max'];
    }

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e) => $this->match($e));
    }

    public function match(Envelope $envelope): bool
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
