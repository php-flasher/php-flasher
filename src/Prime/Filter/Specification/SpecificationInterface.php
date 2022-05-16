<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;

interface SpecificationInterface
{
    /**
     * @return bool
     */
    public function isSatisfiedBy(Envelope $envelope);
}
