<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Envelope;

interface FilterInterface
{
    /**
     * @param Envelope[] $envelopes
     * @param array<string, mixed> $criteria
     *
     * @return Envelope[]
     */
    public function filter(array $envelopes, array $criteria);
}
