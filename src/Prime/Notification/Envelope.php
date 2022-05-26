<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

final class Envelope implements NotificationInterface
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @var array<class-string<StampInterface>, StampInterface>
     */
    private $stamps = array();

    /**
     * @param StampInterface|StampInterface[] $stamps
     */
    public function __construct(NotificationInterface $notification, $stamps = array())
    {
        $this->notification = $notification;
        $this->with(\is_array($stamps) ? $stamps : \array_slice(\func_get_args(), 1));
    }

    /**
     * Dynamically call methods on the notification.
     *
     * @param string  $method
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        /** @var callable $callback */
        $callback = array($this->getNotification(), $method);

        return \call_user_func_array($callback, $parameters);
    }

    /**
     * Makes sure the notification is in an Envelope and adds the given stamps.
     *
     * @param StampInterface|StampInterface[] $stamps
     *
     * @return static
     */
    public static function wrap(NotificationInterface $notification, $stamps = array())
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);

        return $envelope->with(\is_array($stamps) ? $stamps : \array_slice(\func_get_args(), 1));
    }

    /**
     * @param StampInterface|StampInterface[] $stamps
     *
     * @return static
     */
    public function with($stamps)
    {
        $stamps = \is_array($stamps) ? $stamps : \func_get_args();

        foreach ($stamps as $stamp) {
            $this->withStamp($stamp);
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withStamp(StampInterface $stamp)
    {
        $this->stamps[\get_class($stamp)] = $stamp;

        return $this;
    }

    /**
     * @param StampInterface|StampInterface[] $stamps
     *
     * @return static
     */
    public function without($stamps)
    {
        $stamps = \is_array($stamps) ? $stamps : \func_get_args();

        foreach ($stamps as $stamp) {
            $this->withoutStamp($stamp);
        }

        return $this;
    }

    /**
     * @param class-string<StampInterface>|StampInterface $type
     *
     * @return static
     */
    public function withoutStamp($type)
    {
        $type = $type instanceof StampInterface ? \get_class($type) : $type;

        unset($this->stamps[$type]);

        return $this;
    }

    /**
     * @param class-string<StampInterface> $stampFqcn
     *
     * @return StampInterface|null
     */
    public function get($stampFqcn)
    {
        if (!isset($this->stamps[$stampFqcn])) {
            return null;
        }

        return $this->stamps[$stampFqcn];
    }

    /**
     * All stamps by their class name.
     *
     * @return array<class-string<StampInterface>, StampInterface>
     */
    public function all()
    {
        return $this->stamps;
    }

    /**
     * The original notification contained in the envelope.
     *
     * @return NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->notification->getType();
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        return $this->notification->setType($type); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->notification->getMessage();
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage($message)
    {
        return $this->notification->setMessage($message); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->notification->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        return $this->notification->setTitle($title); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->notification->getOptions();
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        return $this->notification->setOptions($options); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name, $default = null)
    {
        return $this->notification->getOption($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($name, $value)
    {
        return $this->notification->setOption($name, $value); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function unsetOption($name)
    {
        return $this->notification->unsetOption($name); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = array(
            'notification' => $this->notification->toArray(),
        );

        foreach ($this->all() as $stamp) {
            if ($stamp instanceof PresentableStampInterface) {
                $array = array_merge($array, $stamp->toArray());
            }
        }

        return $array;
    }
}
