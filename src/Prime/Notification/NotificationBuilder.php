<?php

namespace Flasher\Prime\Notification;

class NotificationBuilder implements NotificationBuilderInterface
{
    /**
     * @var NotificationInterface
     */
    protected $notification;

    /**
     * @param NotificationInterface|null $notification
     */
    public function __construct(NotificationInterface $notification = null)
    {
        $this->notification = $notification ?: new Notification();
    }

    /**
     * @inheritDoc
     */
    public function type($type, $message = null, array $options = array())
    {
        $this->notification->setType($type);

        if (null !== $message) {
            $this->message($message);
        }

        if (array() !== $options) {
            $this->options($options, false);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function message($message)
    {
        $this->notification->setMessage($message);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function options($options, $merge = true)
    {
        if (true === $merge) {
            $options = array_merge($this->notification->getOptions(), $options);
        }

        $this->notification->setOptions($options);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function option($name, $value)
    {
        $this->notification->setOption($name, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @inheritDoc
     */
    public function success($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::TYPE_SUCCESS, $message, $options);
    }

    /**
     * @inheritDoc
     */
    public function error($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::TYPE_ERROR, $message, $options);
    }

    /**
     * @inheritDoc
     */
    public function info($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::TYPE_INFO, $message, $options);
    }

    /**
     * @inheritDoc
     */
    public function warning($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::TYPE_WARNING, $message, $options);
    }

    public function priority($priority)
    {

    }

    public function hops()
    {

    }

    public function sticky()
    {

    }
}
