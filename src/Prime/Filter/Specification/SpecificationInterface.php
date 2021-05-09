<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

interface SpecificationInterface
{
    /**
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
