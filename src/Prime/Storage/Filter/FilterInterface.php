<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Filter\Criteria\CriteriaInterface;

interface FilterInterface
{
    /**
     * @param Envelope[] $envelopes
     *
     * @return Envelope[]
     */
    public function apply(array $envelopes): array;

    public function addCriteria(CriteriaInterface $criteria): void;
}
