<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

trait NotificationBuilderMethods
{
    protected readonly Envelope $envelope;

    public function title(string $title): static
    {
        $this->envelope->setTitle($title);

        return $this;
    }

    public function message(string $message): static
    {
        $this->envelope->setMessage($message);

        return $this;
    }

    public function type(string $type): static
    {
        $this->envelope->setType($type);

        return $this;
    }

    public function options(array $options, bool $append = true): static
    {
        if ($append) {
            $options = array_merge($this->envelope->getOptions(), $options);
        }

        $this->envelope->setOptions($options);

        return $this;
    }

    public function option(string $name, mixed $value): static
    {
        $this->envelope->setOption($name, $value);

        return $this;
    }

    public function priority(int $priority): static
    {
        $this->envelope->withStamp(new PriorityStamp($priority));

        return $this;
    }

    public function keep(): static
    {
        $stamp = $this->envelope->get(HopsStamp::class);
        $amount = $stamp?->getAmount() ?: 1;

        return $this->hops(1 + $amount);
    }

    public function hops(int $amount): static
    {
        $this->envelope->withStamp(new HopsStamp($amount));

        return $this;
    }

    public function delay(int $delay): static
    {
        $this->envelope->withStamp(new DelayStamp($delay));

        return $this;
    }

    public function translate(array $parameters = [], ?string $locale = null): static
    {
        $this->envelope->withStamp(new TranslationStamp($parameters, $locale));

        return $this;
    }

    public function handler(string $handler): static
    {
        $this->envelope->withStamp(new PluginStamp($handler));

        return $this;
    }

    public function context(array $context): static
    {
        $this->envelope->withStamp(new ContextStamp($context));

        return $this;
    }

    public function when(bool|\Closure $condition): static
    {
        $condition = $this->validateCallableCondition($condition);

        $stamp = $this->envelope->get(WhenStamp::class);
        if ($stamp instanceof WhenStamp) {
            $condition = $stamp->getCondition() && $condition;
        }

        $this->envelope->withStamp(new WhenStamp($condition));

        return $this;
    }

    public function unless(bool|\Closure $condition): static
    {
        $condition = $this->validateCallableCondition($condition);

        $stamp = $this->envelope->get(UnlessStamp::class);
        if ($stamp instanceof UnlessStamp) {
            $condition = $stamp->getCondition() || $condition;
        }

        $this->envelope->withStamp(new UnlessStamp($condition));

        return $this;
    }

    public function with(array|StampInterface $stamps): static
    {
        if ($stamps instanceof StampInterface) {
            $stamps = [$stamps];
        }

        $this->envelope->with(...$stamps);

        return $this;
    }

    public function getEnvelope(): Envelope
    {
        return $this->envelope;
    }

    protected function validateCallableCondition(bool|\Closure $condition): bool
    {
        if ($condition instanceof \Closure) {
            $condition = $condition($this->envelope);
        }

        if (!\is_bool($condition)) {
            $type = \gettype($condition);

            throw new \InvalidArgumentException(sprintf('The condition must be a boolean or a closure that returns a boolean. Got: %s', $type));
        }

        return $condition;
    }
}
