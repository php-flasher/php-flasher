<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

/**
 * Envelope - A wrapper for notifications with metadata.
 *
 * Wraps a notification object with "stamps" that provide additional
 * metadata and behavior. This allows attaching cross-cutting concerns
 * to notifications without modifying the notification itself.
 *
 * Design pattern: Decorator + Envelope - Extends functionality of
 * notifications by wrapping them in a container with additional capabilities.
 */
final class Envelope implements NotificationInterface
{
    use ForwardsCalls;

    /**
     * Collection of stamps attached to this envelope, indexed by class name.
     *
     * @var array<class-string<StampInterface>, StampInterface>
     */
    private array $stamps = [];

    /**
     * Creates a new Envelope instance.
     *
     * @param NotificationInterface           $notification The notification to wrap
     * @param StampInterface[]|StampInterface $stamps       One or more stamps to attach to the envelope
     */
    public function __construct(private readonly NotificationInterface $notification, array|StampInterface $stamps = [])
    {
        $stamps = $stamps instanceof StampInterface ? [$stamps] : $stamps;

        $this->with(...$stamps);
    }

    /**
     * Wraps a notification in an Envelope and adds the given stamps.
     *
     * This static factory method provides a convenient way to create and configure
     * an envelope in a single operation.
     *
     * Example:
     * ```php
     * $envelope = Envelope::wrap(new Notification(), [
     *     new PriorityStamp(10),
     *     new HopsStamp(2)
     * ]);
     * ```
     *
     * @param NotificationInterface           $notification The notification to wrap
     * @param StampInterface[]|StampInterface $stamps       One or more stamps to attach to the envelope
     *
     * @return self The created envelope
     */
    public static function wrap(NotificationInterface $notification, array|StampInterface $stamps = []): self
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);
        $stamps = $stamps instanceof StampInterface ? [$stamps] : $stamps;

        $envelope->with(...$stamps);

        return $envelope;
    }

    /**
     * Adds multiple stamps to the envelope.
     *
     * @param StampInterface ...$stamps The stamps to add
     */
    public function with(StampInterface ...$stamps): void
    {
        foreach ($stamps as $stamp) {
            $this->withStamp($stamp);
        }
    }

    /**
     * Adds or replaces a stamp in the envelope.
     *
     * Each stamp class can only have one instance in the envelope at a time.
     * When adding a stamp of a class that already exists, the behavior depends
     * on the $replace parameter:
     * - If true (default), the new stamp replaces the existing one
     * - If false, the existing stamp is preserved
     *
     * @param StampInterface $stamp   The stamp to add
     * @param bool           $replace Whether to replace an existing stamp of the same type
     */
    public function withStamp(StampInterface $stamp, bool $replace = true): void
    {
        if (!isset($this->stamps[$stamp::class]) || $replace) {
            $this->stamps[$stamp::class] = $stamp;
        }
    }

    /**
     * Removes specified stamps from the envelope.
     *
     * @param StampInterface ...$stamps The stamps to remove
     */
    public function without(StampInterface ...$stamps): void
    {
        foreach ($stamps as $stamp) {
            $this->withoutStamp($stamp);
        }
    }

    /**
     * Removes a specific type of stamp from the envelope.
     *
     * @param class-string<StampInterface>|StampInterface $type The type of stamp to remove
     */
    public function withoutStamp(string|StampInterface $type): void
    {
        $type = $type instanceof StampInterface ? $type::class : $type;

        unset($this->stamps[$type]);
    }

    /**
     * Retrieves a stamp by its type.
     *
     * @template T of StampInterface
     *
     * @phpstan-param class-string<T> $type The class name of the stamp to retrieve
     *
     * @return StampInterface|null The stamp if found, null otherwise
     *
     * @phpstan-return T|null
     */
    public function get(string $type): ?StampInterface
    {
        /** @var T|null $stamp */
        $stamp = $this->stamps[$type] ?? null;

        return $stamp;
    }

    /**
     * Returns all stamps by their class name.
     *
     * @return array<class-string<StampInterface>, StampInterface> Map of stamp class names to stamp instances
     */
    public function all(): array
    {
        return $this->stamps;
    }

    /**
     * Gets the original notification contained in the envelope.
     *
     * @return NotificationInterface The wrapped notification
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function getTitle(): string
    {
        return $this->notification->getTitle();
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function setTitle(string $title): void
    {
        $this->notification->setTitle($title);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function getMessage(): string
    {
        return $this->notification->getMessage();
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function setMessage(string $message): void
    {
        $this->notification->setMessage($message);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function getType(): string
    {
        return $this->notification->getType();
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function setType(string $type): void
    {
        $this->notification->setType($type);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function getOptions(): array
    {
        return $this->notification->getOptions();
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function setOptions(array $options): void
    {
        $this->notification->setOptions($options);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function getOption(string $name, mixed $default = null): mixed
    {
        return $this->notification->getOption($name, $default);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function setOption(string $name, mixed $value): void
    {
        $this->notification->setOption($name, $value);
    }

    /**
     * {@inheritdoc}
     *
     * Delegates to the wrapped notification.
     */
    public function unsetOption(string $name): void
    {
        $this->notification->unsetOption($name);
    }

    /**
     * Converts the envelope and its contents to an array format.
     *
     * This method combines the notification data with metadata from all
     * presentable stamps attached to the envelope.
     *
     * @return array{
     *     title: string,
     *     message: string,
     *     type: string,
     *     options: array<string, mixed>,
     *     metadata: array<string, mixed>,
     * } The notification data with metadata
     */
    public function toArray(): array
    {
        $stamps = [];

        foreach ($this->stamps as $stamp) {
            if ($stamp instanceof PresentableStampInterface) {
                $stamps[] = $stamp->toArray();
            }
        }

        return [
            ...$this->notification->toArray(),
            'metadata' => array_merge(...$stamps),
        ];
    }

    /**
     * Dynamically call methods on the wrapped notification.
     *
     * This magic method allows calling methods directly on the envelope
     * which will be forwarded to the wrapped notification.
     *
     * @param string  $method     The method name to call
     * @param mixed[] $parameters The parameters to pass to the method
     *
     * @return mixed The result of the method call
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallTo($this->notification, $method, $parameters);
    }
}
