<?php

namespace Flasher\Prime\Notification;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\EnvelopeDispatchedEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;

class NotificationBuilder implements NotificationBuilderInterface
{
    /**
     * @var Envelope
     */
    protected $envelope;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface   $eventDispatcher
     * @param NotificationInterface|null $notification
     * @param string                     $handler
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        NotificationInterface $notification = null,
        $handler = null
    ) {
        $this->eventDispatcher = $eventDispatcher;

        $notification   = $notification ?: new Notification();
        $this->envelope = Envelope::wrap($notification);

        $handler = $handler ?: get_class($notification);
        $this->handler($handler);
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
    public function handler($handler)
    {
        $this->envelope->withStamp(new HandlerStamp($handler));

        return $this;
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
        $amount    = $hopsStamp instanceof HopsStamp ? $hopsStamp->getAmount() : 1;

        $this->envelope->withStamp(new HopsStamp($amount + 1));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function with(array $stamps = array())
    {
        $this->envelope->with($stamps);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withStamp(StampInterface $stamp)
    {
        $this->envelope->withStamp($stamp);

        return $this;
    }

    /**
     * Dispatch the notification to the flasher bus
     *
     * @param array $stamps
     *
     * @return Envelope|mixed
     */
    public function dispatch($stamps = array())
    {
        if (!empty($stamps)) {
            $this->with($stamps);
        }

        $envelope = $this->getEnvelope();

        $event = new EnvelopeDispatchedEvent($envelope);

        return $this->eventDispatcher->dispatch($event);
    }
}
