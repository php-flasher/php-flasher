<?php

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Notification\Envelope;

final class CallbackSpecification implements SpecificationInterface
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(Filter $filterBuilder, $callback)
    {
        $this->filter = $filterBuilder;
        $this->callback = $callback;
    }

    public function isSatisfiedBy(Envelope $envelope)
    {
        return (bool) \call_user_func($this->callback, $envelope, $this->filter);
    }
}
