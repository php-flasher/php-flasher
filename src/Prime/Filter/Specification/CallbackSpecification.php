<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(Envelope $envelope)
    {
        return (bool) \call_user_func($this->callback, $envelope, $this->filter);
    }
}
