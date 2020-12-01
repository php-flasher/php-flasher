<?php

namespace Flasher\Prime\TestsFilter\Specification;

use Notify\Envelope;

final class NotSpecification implements SpecificationInterface
{
    /**
     * @var \Flasher\Prime\TestsFilter\Specification\SpecificationInterface
     */
    private $specification;

    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        return !$this->specification->isSatisfiedBy($envelope);
    }
}
