<?php

declare(strict_types=1);

namespace Flasher\Prime\Storage\Filter\Criteria;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\IdStamp;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

final class StampsCriteria implements CriteriaInterface
{
    private array $stamps = [];

    private readonly string $strategy;

    public function __construct(mixed $criteria)
    {
        if (!is_array($criteria)) {
            throw new \InvalidArgumentException("Invalid type for criteria 'stamps'.");
        }

        foreach ($criteria as $key => $value) {
            $this->stamps[$key] = $value;
        }
    }

    public const STRATEGY_AND = 'and';

    public const STRATEGY_OR = 'or';

    /**
     * @var array<string, class-string<StampInterface>>
     */
    public const STAMP_ALIASES = [
        'context' => ContextStamp::class,
        'created_at' => CreatedAtStamp::class,
        'delay' => DelayStamp::class,
        'handler' => PluginStamp::class,
        'hops' => HopsStamp::class,
        'preset' => PresetStamp::class,
        'priority' => PriorityStamp::class,
        'translation' => TranslationStamp::class,
        'unless' => UnlessStamp::class,
        'uuid' => IdStamp::class,
        'when' => WhenStamp::class,
    ];

    public function apply(array $envelopes): array
    {
        return array_filter($envelopes, fn (Envelope $e): bool => $this->match($e));
    }

    public function match(Envelope $envelope): bool
    {
        $diff = array_diff($this->stamps, array_keys($envelope->all()));

        if (self::STRATEGY_AND === $this->strategy) {
            return [] === $diff;
        }

        return \count($diff) < \count($this->stamps);
    }
}
