<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;

interface SpecificationInterface
{
    /**
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
