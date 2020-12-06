<?php

namespace Flasher\Prime;

use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;

final class Envelope implements NotificationInterface
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @var StampInterface[]
     */
    private $stamps = array();

    /**
     * @param Envelope|NotificationInterface $notification
     * @param StampInterface[]               $stamps
     */
    public function __construct($notification, $stamps = array())
    {
        $this->notification = $notification;
        $stamps             = is_array($stamps) ? $stamps : array_slice(func_get_args(), 1);
        call_user_func_array(array($this, 'with'), $stamps);
    }

    /**
     * Makes sure the notification is in an Envelope and adds the given stamps.
     *
     * @param NotificationInterface|Envelope $notification
     * @param StampInterface[]               $stamps
     *
     * @return Envelope
     */
    public static function wrap($notification, array $stamps = array())
    {
        $envelope = $notification instanceof self ? $notification : new self($notification);

        return call_user_func_array(array($envelope, 'with'), $stamps);
    }

    /**
     * @param array|StampInterface $stamps
     *
     * @return Envelope a new Envelope instance with additional stamp
     */
    public function with($stamps = array())
    {
        $stamps = is_array($stamps) ? $stamps : func_get_args();

        foreach ($stamps as $stamp) {
            $this->withStamp($stamp);
        }

        return $this;
    }

    /**
     * @param StampInterface $stamp
     *
     * @return $this
     */
    public function withStamp(StampInterface $stamp)
    {
        $this->stamps[get_class($stamp)] = $stamp;

        return $this;
    }

    /**
     * @param string $stampFqcn
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
}