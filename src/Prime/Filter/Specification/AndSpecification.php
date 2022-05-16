<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;

final class AndSpecification implements SpecificationInterface
{
    /**
     * @var SpecificationInterface[]
     */
    private $specifications;

    /**
     * @param SpecificationInterface|SpecificationInterface[] $specifications
     */
    public function __construct($specifications)
    {
        $specifications = \is_array($specifications) ? $specifications : \func_get_args();

        $this->specifications = $specifications;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($envelope)) {
                return false;
            }
        }

        return true;
    }
}
