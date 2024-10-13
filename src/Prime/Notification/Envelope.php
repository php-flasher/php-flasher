<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Support\Traits\ForwardsCalls;

/**
 * Envelope class wraps a notification and manages associated stamps.
 */
final class Envelope implements NotificationInterface
{
    use ForwardsCalls;

    /**
     * @var array<class-string<StampInterface>, StampInterface>
     */
    private array $stamps = [];

    /**
     * @param StampInterface[]|StampInterface $stamps stamps to be added to the envelope
     */
    public function __construct(private readonly NotificationInterface $notification, array|StampInterface $stamps = [])
    {
        $stamps = $stamps instanceof StampInterface ? [$stamps] : $stamps;

        $this->with(...$stamps);
    }

    /**
     * Wraps a notification in an Envelope and adds the given stamps.
     *
     * @param StampInterface|StampInterface[] $stamps stamps to be added to the envelope
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
     * @param StampInterface ...$stamps The stamps to add.
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
     * @param StampInterface $stamp   the stamp to add or replace
     * @param bool           $replace whether to replace an existing stamp of the same type
     */
    public function withStamp(StampInterface $stamp, bool $replace = true): void
    {
        if (!isset($this->stamps[$stamp::class]) || $replace) {
            $this->stamps[$stamp::class] = $stamp;
        }
    }

    /**
     * Removes specified stamps from the envelope.
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
     * @param class-string<StampInterface>|StampInterface $type the type of stamp to remove
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
     * @phpstan-param class-string<T> $type
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
     * All stamps by their class name.
     *
     * @return array<class-string<StampInterface>, StampInterface>
     */
    public function all(): array
    {
        return $this->stamps;
    }

    /**
     * Gets the original notification contained in the envelope.
     *
     * @return NotificationInterface the wrapped notification
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }

    public function getTitle(): string
    {
        return $this->notification->getTitle();
    }

    public function setTitle(string $title): void
    {
        $this->notification->setTitle($title);
    }

    public function getMessage(): string
    {
        return $this->notification->getMessage();
    }

    public function setMessage(string $message): void
    {
        $this->notification->setMessage($message);
    }

    public function getType(): string
    {
        return $this->notification->getType();
    }

    public function setType(string $type): void
    {
        $this->notification->setType($type);
    }

    public function getOptions(): array
    {
        return $this->notification->getOptions();
    }

    public function setOptions(array $options): void
    {
        $this->notification->setOptions($options);
    }

    public function getOption(string $name, mixed $default = null): mixed
    {
        return $this->notification->getOption($name, $default);
    }

    public function setOption(string $name, mixed $value): void
    {
        $this->notification->setOption($name, $value);
    }

    public function unsetOption(string $name): void
    {
        $this->notification->unsetOption($name);
    }

    /**
     * Converts the envelope and its contents to an array format.
     *
     * @return array{
     *     title: string,
     *     message: string,
     *     type: string,
     *     options: array<string, mixed>,
     *     metadata: array<string, mixed>,
     * }
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
     * @param string  $method     the method name to call
     * @param mixed[] $parameters the parameters to pass to the method
     *
     * @return mixed the result of the method call
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->forwardCallTo($this->notification, $method, $parameters);
    }
}
