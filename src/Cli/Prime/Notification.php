<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification as BaseNotification;
use Flasher\Prime\Notification\NotificationInterface;

final class Notification extends BaseNotification
{
    /**
     * @var string|null
     */
    public $message;

    /**
     * @var string
     */
    public $type;

    /**
     * @var array<string, mixed>
     */
    public $options = [];

    /**
     * @param  array<string, mixed>  $options
     */
    public function __construct(public ?string $message = null, private ?string $title = null, private ?string $icon = null, public string $type = self::INFO, public array $options = [])
    {
    }

    /**
     * @param  Notification|string  $notification
     * @return static
     */
    public static function wrap($notification)
    {
        if ($notification instanceof self) {
            return $notification;
        }

        return self::create($notification);
    }

    /**
     * @param  string  $message
     * @param  string|null  $title
     * @param  string|null  $icon
     * @param  string  $type
     * @param  array<string, mixed>  $options
     * @return static
     */
    public static function create($message, $title = null, $icon = null, $type = self::INFO, array $options = []): self
    {
        return new self($message, $title, $icon, $type, $options);
    }

    /**
     * @param  string  $message
     * @param  string|null  $title
     * @param  string|null  $icon
     * @param  array<string, mixed>  $options
     * @return static
     */
    public static function error($message, $title = null, $icon = null, array $options = []): Notification
    {
        return self::create($message, $title, $icon, NotificationInterface::ERROR, $options);
    }

    /**
     * @param  string  $message
     * @param  string|null  $title
     * @param  string|null  $icon
     * @param  array<string, mixed>  $options
     * @return static
     */
    public static function info($message, $title = null, $icon = null, array $options = []): Notification
    {
        return self::create($message, $title, $icon, NotificationInterface::INFO, $options);
    }

    /**
     * @param  string  $message
     * @param  string|null  $title
     * @param  string|null  $icon
     * @param  array<string, mixed>  $options
     * @return static
     */
    public static function success($message, $title = null, $icon = null, array $options = []): Notification
    {
        return self::create($message, $title, $icon, NotificationInterface::SUCCESS, $options);
    }

    /**
     * @param  string  $message
     * @param  string|null  $title
     * @param  string|null  $icon
     * @param  array<string, mixed>  $options
     * @return static
     */
    public static function warning($message, $title = null, $icon = null, array $options = []): Notification
    {
        return self::create($message, $title, $icon, NotificationInterface::WARNING, $options);
    }

    public function getMessage(): string
    {
        $message = parent::getMessage();

        if (\is_string($message)) {
            return addslashes($message);
        }

        return $message;
    }

    public function getOption(string $name, mixed $default = null): mixed
    {
        $option = parent::getOption($name, $default);

        if (\is_string($option)) {
            return addslashes($option);
        }

        return $option;
    }

    /**
     * @return string|null
     */
    public function getTitle(): string
    {
        $title = $this->title;

        if (\is_string($title)) {
            return addslashes($title);
        }

        return $title;
    }

    /**
     * @return static
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return static
     */
    public function setIcon(?string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function toArray(): array
    {
        return [...parent::toArray(), 'title' => $this->getTitle(), 'icon' => $this->icon];
    }

    /**
     * @return static
     */
    public static function fromEnvelope(Envelope $envelope)
    {
        $self = new self();

        $self->setType($envelope->getType());
        $self->setMessage($envelope->getMessage());
        $self->setOptions($envelope->getOptions());

        $notification = $envelope->getNotification();
        if (! $notification instanceof self) {
            return $self;
        }

        $self->setTitle($notification->getTitle());
        $self->setIcon($notification->getIcon());

        return $self;
    }
}
