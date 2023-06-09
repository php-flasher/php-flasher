<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;

final class AndSpecification implements SpecificationInterface
{
    /**
     * @var SpecificationInterface[]
     */
    private array $specifications = [];

    /**
     * @param  SpecificationInterface|SpecificationInterface[]  $specifications
     */
    public function __construct($specifications)
    {
        $specifications = \is_array($specifications) ? $specifications : \func_get_args();

        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        foreach ($this->specifications as $specification) {
            if (! $specification->isSatisfiedBy($envelope)) {
                return false;
            }
        }

        return true;
    }
}
