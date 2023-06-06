<?php

namespace Flasher\Cli\Prime;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Notification\Notification as BaseNotification;
use Flasher\Prime\Notification\NotificationInterface;

final class Notification extends BaseNotification
{
    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $icon;

    /**
     * @param string|null          $message
     * @param string|null          $title
     * @param string|null          $icon
     * @param string               $type
     * @param array<string, mixed> $options
     */
    public function __construct($message = null, $title = null, $icon = null, $type = self::INFO, array $options = [])
    {
        $this->message = $message;
        $this->title = $title;
        $this->icon = $icon;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * @param Notification|string $notification
     *
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
     * @param string               $message
     * @param string|null          $title
     * @param string|null          $icon
     * @param string               $type
     * @param array<string, mixed> $options
     *
     * @return static
     */
    public static function create($message, $title = null, $icon = null, $type = self::INFO, array $options = [])
    {
        return new self($message, $title, $icon, $type, $options);
    }

    /**
     * @param string               $message
     * @param string|null          $title
     * @param string|null          $icon
     * @param array<string, mixed> $options
     *
     * @return static
     */
    public static function error($message, $title = null, $icon = null, array $options = [])
    {
        return self::create($message, $title, $icon, NotificationInterface::ERROR, $options);
    }

    /**
     * @param string               $message
     * @param string|null          $title
     * @param string|null          $icon
     * @param array<string, mixed> $options
     *
     * @return static
     */
    public static function info($message, $title = null, $icon = null, array $options = [])
    {
        return self::create($message, $title, $icon, NotificationInterface::INFO, $options);
    }

    /**
     * @param string               $message
     * @param string|null          $title
     * @param string|null          $icon
     * @param array<string, mixed> $options
     *
     * @return static
     */
    public static function success($message, $title = null, $icon = null, array $options = [])
    {
        return self::create($message, $title, $icon, NotificationInterface::SUCCESS, $options);
    }

    /**
     * @param string               $message
     * @param string|null          $title
     * @param string|null          $icon
     * @param array<string, mixed> $options
     *
     * @return static
     */
    public static function warning($message, $title = null, $icon = null, array $options = [])
    {
        return self::create($message, $title, $icon, NotificationInterface::WARNING, $options);
    }

    public function getMessage()
    {
        $message = parent::getMessage();

        if (\is_string($message)) {
            $message = addslashes($message);
        }

        return $message;
    }

    public function getOption($name, $default = null)
    {
        $option = parent::getOption($name, $default);

        if (\is_string($option)) {
            $option = addslashes($option);
        }

        return $option;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        $title = $this->title;

        if (\is_string($title)) {
            $title = addslashes($title);
        }

        return $title;
    }

    /**
     * @param string|null $title
     *
     * @return static
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     *
     * @return static
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'title' => $this->getTitle(),
            'icon' => $this->getIcon(),
        ]);
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
        if (!$notification instanceof self) {
            return $self;
        }

        $self->setTitle($notification->getTitle());
        $self->setIcon($notification->getIcon());

        return $self;
    }
}
