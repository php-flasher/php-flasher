<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\ContextStamp;
use Flasher\Prime\Stamp\DelayStamp;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\HopsStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NotificationBuilder implements NotificationBuilderInterface
{
    /**
     * @var Envelope
     */
    protected $envelope;

    /**
     * @var StorageManagerInterface
     */
    protected $storageManager;

    /**
     * @var array<string, callable>
     */
    protected static $macros = array();

    /**
     * @param string $handler
     */
    public function __construct(StorageManagerInterface $storageManager, NotificationInterface $notification, $handler = null)
    {
        $this->storageManager = $storageManager;
        $this->envelope = Envelope::wrap($notification);

        if (null !== $handler) {
            $this->handler($handler);
        }
    }

    /**
     * @param string  $method
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', \get_called_class(), $method));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof \Closure) {
            /** @var callable $callback */
            $callback = \Closure::bind($macro, null, \get_called_class());

            return \call_user_func_array($callback, $parameters);
        }

        return \call_user_func_array($macro, $parameters);
    }

    /**
     * @param string  $method
     * @param mixed[] $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (!static::hasMacro($method)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', \get_called_class(), $method));
        }

        $macro = static::$macros[$method];

        if ($macro instanceof \Closure) {
            /** @var callable $callback */
            $callback = $macro->bindTo($this, \get_called_class());

            return \call_user_func_array($callback, $parameters);
        }

        return \call_user_func_array($macro, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function addSuccess($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::SUCCESS, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addError($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::ERROR, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addWarning($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::WARNING, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addInfo($message, array $options = array())
    {
        return $this->addFlash(NotificationInterface::INFO, $message, $options);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function flash(array $stamps = array())
    {
        if (array() !== $stamps) {
            $this->with($stamps);
        }

        $this->storageManager->add($this->getEnvelope());

        return $this->getEnvelope();
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function message($message)
    {
        $this->envelope->setMessage($message);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function title($title)
    {
        $this->envelope->setTitle($title);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function options(array $options, $merge = true)
    {
        if (true === $merge) {
            $options = array_merge($this->envelope->getOptions(), $options);
        }

        $this->envelope->setOptions($options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function option($name, $value)
    {
        $this->envelope->setOption($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function success($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::SUCCESS, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::ERROR, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::INFO, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message = null, array $options = array())
    {
        return $this->type(NotificationInterface::WARNING, $message, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function priority($priority)
    {
        $this->envelope->withStamp(new PriorityStamp($priority));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hops($amount)
    {
        $this->envelope->withStamp(new HopsStamp($amount));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function keep()
    {
        $hopsStamp = $this->envelope->get('Flasher\Prime\Stamp\HopsStamp');
        $amount = $hopsStamp instanceof HopsStamp ? $hopsStamp->getAmount() : 1;

        $this->envelope->withStamp(new HopsStamp($amount + 1));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function delay($delay)
    {
        $this->envelope->withStamp(new DelayStamp($delay));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function now()
    {
        return $this->delay(0);
    }

    /**
     * {@inheritdoc}
     */
    public function with($stamps = array())
    {
        $this->envelope->with($stamps);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withStamp(StampInterface $stamp)
    {
        $this->envelope->withStamp($stamp);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * {@inheritdoc}
     */
    public function handler($handler)
    {
        $this->envelope->withStamp(new HandlerStamp($handler));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function context(array $context)
    {
        $this->envelope->withStamp(new ContextStamp($context));

        return $this;
    }

    /**
     * @param string   $name
     * @param callable $macro
     *
     * @return void
     */
    public static function macro($name, $macro)
    {
        static::$macros[$name] = $macro;
    }

    /**
     * @param object $mixin
     * @param bool   $replace
     *
     * @return void
     */
    public static function mixin($mixin, $replace = true)
    {
        $reflection = new \ReflectionClass($mixin);
        $methods = $reflection->getMethods(
            \ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED
        );

        foreach ($methods as $method) {
            if ($replace || !static::hasMacro($method->name)) {
                $method->setAccessible(true);

                /** @var callable $callable */
                $callable = $method->invoke($mixin);
                static::macro($method->name, $callable);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function hasMacro($name)
    {
        return isset(static::$macros[$name]);
    }
}
