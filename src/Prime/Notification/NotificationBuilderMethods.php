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

/**
 * Core notification builder methods.
 *
 * This trait implements the core builder methods for configuring notifications.
 * It provides the fluent API for setting notification properties and attaching stamps.
 */
trait NotificationBuilderMethods
{
    /**
     * The notification envelope being built.
     */
    protected readonly Envelope $envelope;

    /**
     * Sets the notification title.
     *
     * @param string $title The title to set
     *
     * @return static The builder instance for method chaining
     */
    public function title(string $title): static
    {
        $this->envelope->setTitle($title);

        return $this;
    }

    /**
     * Sets the notification message.
     *
     * @param string $message The message to set
     *
     * @return static The builder instance for method chaining
     */
    public function message(string $message): static
    {
        $this->envelope->setMessage($message);

        return $this;
    }

    /**
     * Sets the notification type.
     *
     * @param string $type The type to set (e.g., "success", "error", "info", "warning")
     *
     * @return static The builder instance for method chaining
     */
    public function type(string $type): static
    {
        $this->envelope->setType($type);

        return $this;
    }

    /**
     * Sets multiple options for the notification.
     *
     * @param array<string, mixed> $options The options to set
     * @param bool                 $append  Whether to merge with existing options (true) or replace them (false)
     *
     * @return static The builder instance for method chaining
     */
    public function options(array $options, bool $append = true): static
    {
        if ($append) {
            $options = array_merge($this->envelope->getOptions(), $options);
        }

        $this->envelope->setOptions($options);

        return $this;
    }

    /**
     * Sets a single option for the notification.
     *
     * @param string $name  The option name
     * @param mixed  $value The option value
     *
     * @return static The builder instance for method chaining
     */
    public function option(string $name, mixed $value): static
    {
        $this->envelope->setOption($name, $value);

        return $this;
    }

    /**
     * Sets the notification priority.
     *
     * Higher priority notifications are typically displayed before lower priority ones.
     *
     * @param int $priority The priority value (higher values indicate higher priority)
     *
     * @return static The builder instance for method chaining
     */
    public function priority(int $priority): static
    {
        $this->envelope->withStamp(new PriorityStamp($priority));

        return $this;
    }

    /**
     * Increases the number of request hops the notification will persist.
     *
     * This method is useful for keeping a notification across multiple redirects.
     * It increments the current hop count by 1, ensuring the notification persists
     * for one additional request.
     *
     * @return static The builder instance for method chaining
     */
    public function keep(): static
    {
        $stamp = $this->envelope->get(HopsStamp::class);
        $amount = $stamp?->getAmount() ?: 1;

        return $this->hops(1 + $amount);
    }

    /**
     * Sets the exact number of request hops the notification will persist.
     *
     * This determines how many redirects/page loads a notification will survive.
     * For example, a value of 2 means the notification will be shown on the current
     * request and the next request, then be removed.
     *
     * @param int $amount The number of hops to keep the notification
     *
     * @return static The builder instance for method chaining
     */
    public function hops(int $amount): static
    {
        $this->envelope->withStamp(new HopsStamp($amount));

        return $this;
    }

    /**
     * Sets a delay before showing the notification.
     *
     * @param int $delay The delay in milliseconds
     *
     * @return static The builder instance for method chaining
     */
    public function delay(int $delay): static
    {
        $this->envelope->withStamp(new DelayStamp($delay));

        return $this;
    }

    /**
     * Configures translation parameters for the notification.
     *
     * This allows the message and title to be translated according to the current locale.
     * Parameters can be used for variable substitution in translation strings.
     *
     * @param array<string, mixed> $parameters Translation parameters
     * @param string|null          $locale     Specific locale to use, or null for default
     *
     * @return static The builder instance for method chaining
     */
    public function translate(array $parameters = [], ?string $locale = null): static
    {
        $this->envelope->withStamp(new TranslationStamp($parameters, $locale));

        return $this;
    }

    /**
     * Sets the handler (plugin) that should process the notification.
     *
     * This specifies which adapter (e.g., 'toastr', 'sweetalert') should be used
     * to render the notification.
     *
     * @param string $handler The handler/plugin name
     *
     * @return static The builder instance for method chaining
     */
    public function handler(string $handler): static
    {
        $this->envelope->withStamp(new PluginStamp($handler));

        return $this;
    }

    /**
     * Sets additional context data for the notification.
     *
     * Context data can be used for customizing the rendering of notifications
     * or providing additional information to handlers.
     *
     * @param array<string, mixed> $context The context data
     *
     * @return static The builder instance for method chaining
     */
    public function context(array $context): static
    {
        $this->envelope->withStamp(new ContextStamp($context));

        return $this;
    }

    /**
     * Adds a condition that must be true for the notification to be displayed.
     *
     * When multiple when() conditions are used, all must be true (AND logic).
     *
     * @param bool|\Closure $condition A boolean or closure returning a boolean
     *
     * @return static The builder instance for method chaining
     */
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

    /**
     * Adds a condition that must be false for the notification to be displayed.
     *
     * When multiple unless() conditions are used, all must be false (OR logic for the negation).
     *
     * @param bool|\Closure $condition A boolean or closure returning a boolean
     *
     * @return static The builder instance for method chaining
     */
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

    /**
     * Adds one or more stamps to the notification envelope.
     *
     * @param StampInterface[]|StampInterface $stamps The stamps to add
     *
     * @return static The builder instance for method chaining
     */
    public function with(array|StampInterface $stamps): static
    {
        if ($stamps instanceof StampInterface) {
            $stamps = [$stamps];
        }

        $this->envelope->with(...$stamps);

        return $this;
    }

    /**
     * Gets the current notification envelope.
     *
     * @return Envelope The notification envelope
     */
    public function getEnvelope(): Envelope
    {
        return $this->envelope;
    }

    /**
     * Validates that a condition is either a boolean or a closure returning a boolean.
     *
     * If the condition is a closure, it is evaluated with the current envelope as parameter.
     *
     * @param bool|\Closure $condition The condition to validate
     *
     * @return bool The evaluated boolean condition
     *
     * @throws \InvalidArgumentException If the condition is not a boolean or doesn't return a boolean
     */
    protected function validateCallableCondition(bool|\Closure $condition): bool
    {
        if ($condition instanceof \Closure) {
            $condition = $condition($this->envelope);
        }

        if (!\is_bool($condition)) {
            $type = \gettype($condition);

            throw new \InvalidArgumentException(\sprintf('The condition must be a boolean or a closure that returns a boolean. Got: %s', $type));
        }

        return $condition;
    }
}
