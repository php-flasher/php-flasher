<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Notification\Envelope;

final class FilterEvent
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @param Envelope[]           $envelopes
     * @param array<string, mixed> $criteria
     */
    public function __construct(array $envelopes, array $criteria)
    {
        $this->filter = new Filter($envelopes, $criteria);
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes()
    {
        return $this->filter->getResult();
    }

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return void
     */
    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;
    }
}
