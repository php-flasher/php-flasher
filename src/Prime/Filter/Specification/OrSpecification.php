<?php

namespace Flasher\Prime\TestsFilter\Specification;

use Notify\Envelope;

final class OrSpecification implements SpecificationInterface
{
    /**
     * @var \Flasher\Prime\TestsFilter\Specification\SpecificationInterface[]
     */
    private $specifications;

    /**
     * @param array|mixed ...$specifications
     */
    public function __construct($specifications = array())
    {
        $specifications = is_array($specifications) ? $specifications : func_get_args();

        $this->specifications = $specifications;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($envelope)) {
                return true;
            }
        }

        return false;
    }
}
