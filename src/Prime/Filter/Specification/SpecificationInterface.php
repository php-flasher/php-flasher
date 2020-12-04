<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

interface SpecificationInterface
{
    /**
     * @param Envelope $envelope
     *
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
