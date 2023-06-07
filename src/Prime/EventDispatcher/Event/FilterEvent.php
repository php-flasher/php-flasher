<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Notification\Envelope;

final class FilterEvent
{
    private Filter $filter;

    /**
     * @param  Envelope[]  $envelopes
     * @param  array<string, mixed>  $criteria
     */
    public function __construct(array $envelopes, array $criteria)
    {
        $this->filter = new Filter($envelopes, $criteria);
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes(): array
    {
        return $this->filter->getResult();
    }

    public function getFilter(): Filter
    {
        return $this->filter;
    }

    public function setFilter(Filter $filter): void
    {
        $this->filter = $filter;
    }
}
