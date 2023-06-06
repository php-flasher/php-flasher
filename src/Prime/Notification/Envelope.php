<?php

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

final class Envelope implements NotificationInterface
{
    /**
     * @var array<class-string<StampInterface>, StampInterface>
     */
    private array $stamps = [];

    /**
     * @param StampInterface[]|StampInterface $stamps
     */
    public function __construct(
        private readonly NotificationInterface $notification,
        array|StampInterface $stamps = []
    ) {
        if ($stamps instanceof StampInterface) {
            $stamps = [$stamps];
        }

        $this->with(...$stamps);
    }

    /**
     * Makes sure the notification is in an Envelope and adds the given stamps.
     *
     * @param StampInterface|StampInterface[] $stamps
     */
    public static function wrap(NotificationInterface $notification, array|StampInterface $stamps = []): self
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);

        if ($stamps instanceof StampInterface) {
            $stamps = [$stamps];
        }

        $envelope->with(...$stamps);

        return $envelope;
    }

    public function with(StampInterface ...$stamps): void
    {
        foreach ($stamps as $stamp) {
            $this->withStamp($stamp);
        }
    }

    public function withStamp(StampInterface $stamp): void
    {
        $this->stamps[$stamp::class] = $stamp;
    }

    /**
     * @param StampInterface[]|StampInterface $stamps
     */
    public function without(array|StampInterface $stamps): void
    {
        if ($stamps instanceof StampInterface) {
            $stamps = [$stamps];
        }

        foreach ($stamps as $stamp) {
            $this->withoutStamp($stamp);
        }
    }

    /**
     * @param class-string<StampInterface>|StampInterface $type
     */
    public function withoutStamp(string|StampInterface $type): void
    {
        $type = $type instanceof StampInterface ? $type::class : $type;

        unset($this->stamps[$type]);
    }

    /**
     * @param class-string<StampInterface> $type
     */
    public function get(string $type): ?StampInterface
    {
        return $this->stamps[$type] ?? null;
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
     * The original notification contained in the envelope.
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
     * @return array{
     *     title: string,
     *     message: string,
     *     type: string,
     *     options: array<string, mixed>,
     *     stamps: array<string, mixed>,
     * }
     */
    public function toArray(): array
    {
        $stamps = [];

        foreach ($this->all() as $stamp) {
            if ($stamp instanceof PresentableStampInterface) {
                $stamps[] = $stamp->toArray();
            }
        }

        return array_merge($this->notification->toArray(), [
            'stamps' => array_merge(...$stamps),
        ]);
    }

    /**
     * Dynamically call methods on the notification.
     *
     * @param mixed[] $parameters
     */
    public function __call(string $method, array $parameters): mixed
    {
        /** @var callable $callback */
        $callback = [$this->getNotification(), $method];

        return $callback(...$parameters);
    }
}
