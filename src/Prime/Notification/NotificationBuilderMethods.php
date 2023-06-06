<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;

trait NotificationBuilderMethods
{
    public function title(string $title): self
    {
        $this->envelope->setTitle($title);

        return $this;
    }

    public function message(string $message): self
    {
        $this->envelope->setMessage($message);

        return $this;
    }

    public function type(string $type): self
    {
        $this->envelope->setType($type);

        return $this;
    }

    public function options(array $options, bool $merge = true): self
    {
        if (true === $merge) {
            $options = array_merge($this->envelope->getOptions(), $options);
        }

        $this->envelope->setOptions($options);

        return $this;
    }

    public function option(string $name, mixed $value): self
    {
        $this->envelope->setOption($name, $value);

        return $this;
    }

    public function when(bool|\Closure $condition): self
    {
        $condition = $this->validateCallableCondition($condition);

        $stamp = $this->envelope->get(WhenStamp::class);
        if ($stamp instanceof WhenStamp) {
            $condition = $stamp->getCondition() && $condition;
        }

        $this->envelope->withStamp(new WhenStamp($condition));

        return $this;
    }

    public function unless(bool|\Closure $condition): self
    {
        $condition = $this->validateCallableCondition($condition);

        $stamp = $this->envelope->get(UnlessStamp::class);
        if ($stamp instanceof UnlessStamp) {
            $condition = $stamp->getCondition() || $condition;
        }

        $this->envelope->withStamp(new UnlessStamp($condition));

        return $this;
    }

    public function priority(int $priority): self
    {
        $this->envelope->withStamp(new PriorityStamp($priority));

        return $this;
    }

    public function keep(): self
    {
        $hopsStamp = $this->envelope->get(HopsStamp::class);
        $amount = $hopsStamp?->getAmount() ?: 1;

        $this->envelope->withStamp(new HopsStamp(1 + $amount));

        return $this;
    }

    public function hops(int $amount): self
    {
        $this->envelope->withStamp(new HopsStamp($amount));

        return $this;
    }

    public function now(): self
    {
        return $this->delay(0);
    }

    public function delay(int $delay): self
    {
        $this->envelope->withStamp(new DelayStamp($delay));

        return $this;
    }

    public function translate(array $parameters = [], string $locale = null): self
    {
        $this->envelope->withStamp(new TranslationStamp($parameters, $locale));

        return $this;
    }

    public function handler(string $handler): self
    {
        $this->envelope->withStamp(new HandlerStamp($handler));

        return $this;
    }

    public function context(array $context): self
    {
        $this->envelope->withStamp(new ContextStamp($context));

        return $this;
    }

    public function with(array|StampInterface $stamps): self
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

        if (!is_bool($condition)) {
            $type = gettype($condition);

            throw new \InvalidArgumentException("The condition must be a boolean or a closure that returns a boolean. Got: {$type}");
        }

        return $condition;
    }
}
