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

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('delay', $criteria);

        $this->minDelay = $criteria['min'];
        $this->maxDelay = $criteria['max'];
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     */
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

        $meetsMin = null === $this->minDelay || $delay >= $this->minDelay;
        $meetsMax = null === $this->maxDelay || $delay <= $this->maxDelay;

        return $meetsMin && $meetsMax;
    }
}
