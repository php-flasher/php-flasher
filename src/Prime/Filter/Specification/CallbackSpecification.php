<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\FilterBuilder;

final class CallbackSpecification implements SpecificationInterface
{
    /** @var FilterBuilder $filterBuilder */
    private $filterBuilder;

    /** @var callable $callback */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(FilterBuilder $filterBuilder, $callback)
    {
        $this->filterBuilder = $filterBuilder;
        $this->callback = $callback;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        return call_user_func($this->callback, $envelope, $this->filterBuilder);
    }
}
