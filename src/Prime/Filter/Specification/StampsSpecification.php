<?php

declare(strict_types=1);

namespace Flasher\Prime\Filter\Specification;

use Flasher\Prime\Notification\Envelope;

final class StampsSpecification implements SpecificationInterface
{
    /**
     * @var string
     */
    public const STRATEGY_AND = 'and';

    /**
     * @var string
     */
    public const STRATEGY_OR = 'or';

    /**
     * @var array|string[]
     */
    private readonly array $stamps;

    /**
     * @param  string|string[]  $stamps
     * @param  string  $strategy
     */
    public function __construct($stamps, private $strategy)
    {
        $this->stamps = (array) $stamps;
    }

    public function isSatisfiedBy(Envelope $envelope): bool
    {
        $diff = array_diff($this->stamps, array_keys($envelope->all()));

        if (self::STRATEGY_AND === $this->strategy) {
            return [] === $diff;
        }

        return \count($diff) < \count($this->stamps);
    }
}
