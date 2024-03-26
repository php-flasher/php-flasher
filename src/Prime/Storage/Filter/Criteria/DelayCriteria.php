<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\DelayStamp;

final readonly class DelayCriteria implements CriteriaInterface
{
    use RangeExtractor;

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
        return array_filter($envelopes, fn (Envelope $envelope): bool => $this->match($envelope));
    }

    public function match(Envelope $envelope): bool
    {
        $stamp = $envelope->get(DelayStamp::class);

        if (!$stamp instanceof DelayStamp) {
            return false;
        }

        $delay = $stamp->getDelay();

        if (null === $this->maxDelay) {
            return $delay >= $this->minDelay;
        }

        if ($delay <= $this->maxDelay) {
            return $delay >= $this->minDelay;
        }

        return false;
    }
}
