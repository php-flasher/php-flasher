<?php

namespace Flasher\Prime\TestsFilter\Specification;

use Notify\Envelope;

interface SpecificationInterface
{
    /**
     * @param \Notify\Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
