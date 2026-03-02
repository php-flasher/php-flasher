<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PriorityStamp;

final readonly class PriorityCriteria implements CriteriaInterface
{
    use RangeExtractor;

    private ?int $minPriority;

    private ?int $maxPriority;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(mixed $criteria)
    {
        $criteria = $this->extractRange('priority', $criteria);

        $this->minPriority = $criteria['min'];
        $this->maxPriority = $criteria['max'];
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
        $stamp = $envelope->get(PriorityStamp::class);

        if (!$stamp instanceof PriorityStamp) {
            return false;
        }

        $priority = $stamp->getPriority();

        $meetsMin = null === $this->minPriority || $priority >= $this->minPriority;
        $meetsMax = null === $this->maxPriority || $priority <= $this->maxPriority;

        return $meetsMin && $meetsMax;
    }
}
