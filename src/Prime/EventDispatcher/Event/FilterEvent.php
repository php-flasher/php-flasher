<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\Filter;
use Flasher\Prime\Storage\Filter\FilterInterface;

final class FilterEvent
{
    /**
     * @param Envelope[]           $envelopes
     * @param array<string, mixed> $criteria
     */
    public function __construct(
        private FilterInterface $filter,
        private array $envelopes,
        private readonly array $criteria,
    ) {
    }

    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }

    public function setFilter(Filter $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * @param Envelope[] $envelopes
     */
    public function setEnvelopes(array $envelopes): void
    {
        $this->envelopes = $envelopes;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }
}
