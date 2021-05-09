<?php

namespace Flasher\Prime\Filter;

use Flasher\Prime\Envelope;

interface FilterInterface
{
    /**
     * @param Envelope[] $envelopes
     *
     * @return array
     */
    public function filter(array $envelopes, array $criteria);
}
