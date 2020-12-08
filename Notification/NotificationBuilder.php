<?php

namespace Flasher\Prime\Notification;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PostBuildEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Stamp\DelayStamp;
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
     * @param EventDispatcherInterface $eventDispatcher
     * @param NotificationInterface    $notification
     * @param string                   $handler
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, NotificationInterface $notification, $handler)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->envelope = Envelope::wrap($notification);
        $this->handler($handler);
    }

    /**
     * @param string $message
     * @param array  $options
     *
     * @return Envelope
     */
    public function addSuccess($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::TYPE_SUCCESS, $message, $options);
    }

    /**
     * @param string $message
     * @param array  $options
     *
     * @return Envelope
     */
    public function addError($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::TYPE_ERROR, $message, $options);
    }

    /**
     * @param string $message
     * @param array  $options
     *
     * @return Envelope
     */
    public function addWarning($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::TYPE_WARNING, $message, $options);
    }

    /**
     * @param string $message
     * @param array  $options
     *
     * @return Envelope
     */
    public function addInfo($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::TYPE_INFO, $message, $options);
    }

    /**
     * @inheritDoc
     */
    public function addFlash($type, $message = null, array $options = array())
    {
        if ($type instanceof NotificationInterface) {
            $this->envelope = Envelope::wrap($type);
            $type = $this->envelope->getType();
        }

        $this->type($type, $message, $options);

        return $this->flash();
    }

    /**
     * @inheritDoc
     */
    public function flash($stamps = array())
    {
        if (!empty($stamps)) {
            $this->with($stamps);
        }

        $event = new PostBuildEvent($this->getEnvelope());

        return $this->eventDispatcher->dispatch($event);
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
        $this->envelope->setMessage(addslashes($message));

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
        $amount    = $hopsStamp instanceof HopsStamp ? $hopsStamp->getAmount() : 1;

        $this->envelope->withStamp(new HopsStamp($amount + 1));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function delay($delay)
    {
        $this->envelope->withStamp(new DelayStamp($delay));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function now()
    {
        return $this->delay(0);
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
     * @inheritDoc
     */
    public function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * @inheritDoc
     */
    public function handler($handler)
    {
        $this->envelope->withStamp(new HandlerStamp($handler));

        return $this;
    }
}
