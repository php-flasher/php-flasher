<?php

namespace Flasher\Prime;

use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\PresentableStampInterface;
use Flasher\Prime\Stamp\StampInterface;

final class Envelope implements NotificationInterface
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @template T of StampInterface
     *
     * @var array<string, T>
     */
    private $stamps = array();

    /**
     * @param StampInterface[]|StampInterface      $stamps
     */
    public function __construct(NotificationInterface $notification, $stamps = array())
    {
        $this->notification = $notification;
        $this->with(is_array($stamps) ? $stamps : array_slice(func_get_args(), 1));
    }

    /**
     * Makes sure the notification is in an Envelope and adds the given stamps.
     *
     * @param StampInterface[]|StampInterface      $stamps
     *
     * @return self
     */
    public static function wrap(NotificationInterface $notification, $stamps = array())
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);

        return $envelope->with(is_array($stamps) ? $stamps : array_slice(func_get_args(), 1));
    }

    /**
     * @param StampInterface[]|StampInterface $stamps
     *
     * @return self a new Envelope instance with additional stamp
     */
    public function with($stamps)
    {
        $stamps = is_array($stamps) ? $stamps : func_get_args();

        foreach ($stamps as $stamp) {
            $this->withStamp($stamp);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function withStamp(StampInterface $stamp)
    {
        $this->stamps[get_class($stamp)] = $stamp;

        return $this;
    }

    /**
     * @param StampInterface[]|StampInterface $stamps
     *
     * @return self A new Envelope instance without any stamps of the given class
     */
    public function without($stamps)
    {
        $stamps = is_array($stamps) ? $stamps : func_get_args();

        foreach ($stamps as $stamp) {
            $this->withoutStamp($stamp);
        }

        return $this;
    }

    /**
     * @param string|StampInterface $type
     *
     * @return self
     */
    public function withoutStamp($type)
    {
        $type = $type instanceof StampInterface ? get_class($type) : $type;

        unset($this->stamps[$type]);

        return $this;
    }

    /**
     * @template T of StampInterface
     *
     * @param class-string<T> $stampFqcn
     *
     * @return T|null
     */
    public function get($stampFqcn)
    {
        if (!isset($this->stamps[$stampFqcn])) {
            return null;
        }

        // @phpstan-ignore-next-line
        return $this->stamps[$stampFqcn];
    }

    /**
     * All stamps by their class name
     *
     * @return StampInterface[]
     */
    public function all()
    {
        return $this->stamps;
    }

    /**
     * The original notification contained in the envelope
     *
     * @return NotificationInterface
     */
    public function getNotification()
    {
        return $this->notification;
    }

    public function getType()
    {
        return $this->notification->getType();
    }

    public function setType($type)
    {
        $this->notification->setType($type);
    }

    public function getMessage()
    {
        return $this->notification->getMessage();
    }

    public function setMessage($message)
    {
        $this->notification->setMessage($message);
    }

    public function getOptions()
    {
        return $this->notification->getOptions();
    }

    public function setOptions(array $options)
    {
        $this->notification->setOptions($options);
    }

    public function getOption($name, $default = null)
    {
        return $this->notification->getOption($name, $default);
    }

    public function setOption($name, $value)
    {
        $this->notification->setOption($name, $value);
    }

    public function unsetOption($name)
    {
        $this->notification->unsetOption($name);
    }

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

    /**
     * Dynamically call methods on the notification
     *
     * @param string $method
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public function __call($method, array $parameters)
    {
        /** @var callable $callback */
        $callback = array($this->getNotification(), $method);

        return call_user_func_array($callback, $parameters);
    }
}
