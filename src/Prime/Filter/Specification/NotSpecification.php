<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;

final class NotSpecification implements SpecificationInterface
{
    /**
     * @var SpecificationInterface
     */
    private $specification;

    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        return !$this->specification->isSatisfiedBy($envelope);
    }
}
