<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Filter\Filter;
use Flasher\Prime\Notification\Envelope;

final class CallbackSpecification implements SpecificationInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param  callable  $callback
     */
    public function __construct(private readonly Filter $filter, $callback)
    {
        $this->callback = $callback;
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        return (bool) \call_user_func($this->callback, $envelope, $this->filter);
    }
}
