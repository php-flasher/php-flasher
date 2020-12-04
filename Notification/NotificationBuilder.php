<?php

namespace Flasher\Prime\Notification;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;

class NotificationBuilder implements NotificationBuilderInterface
{
    /**
     * @var Envelope
     */
    protected $envelope;

    /**
     * @param NotificationInterface|null $notification
     */
    public function __construct(NotificationInterface $notification = null)
    {
        $notification = $notification ?: new Notification();

        $this->envelope = Envelope::wrap($notification);
    }

    /**
     * @inheritDoc
     */
    public function type($type, $message = null, array $options = array())
    {
        $this->envelope->setType($type);

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
        $this->envelope->setMessage($message);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function options($options, $merge = true)
    {
        if (true === $merge) {
            $options = array_merge($this->envelope->getOptions(), $options);
        }

        $this->envelope->setOptions($options);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function option($name, $value)
    {
        $this->envelope->setOption($name, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getNotification()
    {
        return $this->getEnvelope();
    }

    /**
     * @return NotificationInterface
     */
    public function getEnvelope()
    {
        return $this->envelope;
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

    /**
     * @inheritDoc
     */
    public function priority($priority)
    {
        $this->envelope->withStamp(new PriorityStamp($priority));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hops($amount)
    {
        $this->envelope->withStamp(new HopsStamp($amount));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keep()
    {
        $hopsStamp = $this->envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $amount = $hopsStamp instanceof HopsStamp ? $hopsStamp->getAmount() : 1;

        $this->envelope->withStamp(new HopsStamp($amount + 1));

        return $this;
    }
}
