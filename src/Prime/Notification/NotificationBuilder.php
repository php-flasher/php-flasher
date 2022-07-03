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
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\PriorityStamp;
use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Stamp\UnlessStamp;
use Flasher\Prime\Stamp\WhenStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Translation\ResourceInterface;

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
    public function addSuccess($message, $title = null, array $options = array())
    {
        return $this->addFlash(NotificationInterface::SUCCESS, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addError($message, $title = null, array $options = array())
    {
        return $this->addFlash(NotificationInterface::ERROR, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addWarning($message, $title = null, array $options = array())
    {
        return $this->addFlash(NotificationInterface::WARNING, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addInfo($message, $title = null, array $options = array())
    {
        return $this->addFlash(NotificationInterface::INFO, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function addFlash($type, $message = null, $title = null, array $options = array())
    {
        if ($type instanceof NotificationInterface) {
            $this->envelope = Envelope::wrap($type);
            $type = $this->envelope->getType();
        }

        $this->type($type, $message, $title, $options); // @phpstan-ignore-line

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
    public function type($type, $message = null, $title = null, array $options = array())
    {
        $this->envelope->setType($type);

        if (null !== $message) {
            $this->message($message);
        }

        if (\is_array($title)) {
            $options = $title;
            $title = null;
            @trigger_error('Since php-flasher/flasher v1.0: Passing an array for the "title" parameter is deprecated and will be removed in v2.0. You should pass a string instead.', \E_USER_DEPRECATED);
        }

        if (null !== $title) {
            $this->title($title);
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
    public function success($message = null, $title = null, array $options = array())
    {
        return $this->type(NotificationInterface::SUCCESS, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message = null, $title = null, array $options = array())
    {
        return $this->type(NotificationInterface::ERROR, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message = null, $title = null, array $options = array())
    {
        return $this->type(NotificationInterface::INFO, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message = null, $title = null, array $options = array())
    {
        return $this->type(NotificationInterface::WARNING, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function when($condition)
    {
        if ($condition instanceof \Closure) {
            $condition = \call_user_func($condition, $this->envelope);
        }

        if (!\is_bool($condition)) {
            throw new \InvalidArgumentException('The condition must be a boolean or a closure that returns a boolean.');
        }

        $stamp = $this->envelope->get('Flasher\Prime\Stamp\WhenStamp');
        if ($stamp instanceof WhenStamp) {
            $condition = $stamp->getCondition() && $condition;
        }

        $this->envelope->withStamp(new WhenStamp($condition));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unless($condition)
    {
        if ($condition instanceof \Closure) {
            $condition = \call_user_func($condition, $this->envelope);
        }

        if (!\is_bool($condition)) {
            throw new \InvalidArgumentException('The condition must be a boolean or a closure that returns a boolean.');
        }

        $stamp = $this->envelope->get('Flasher\Prime\Stamp\UnlessStamp');
        if ($stamp instanceof UnlessStamp) {
            $condition = $stamp->getCondition() || $condition;
        }

        $this->envelope->withStamp(new UnlessStamp($condition));

        return $this;
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
    public function translate($parameters = array(), $locale = null)
    {
        $order = TranslationStamp::parametersOrder($parameters, $locale);
        $parameters = $order['parameters'];
        $locale = $order['locale'];

        $this->envelope->withStamp(new TranslationStamp($parameters, $locale));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addPreset($preset, $parameters = array())
    {
        $this->preset($preset, $parameters);

        return $this->flash();
    }

    /**
     * {@inheritdoc}
     */
    public function addOperation($operation, $resource = null)
    {
        $this->operation($operation, $resource);

        return $this->flash();
    }

    /**
     * {@inheritdoc}
     */
    public function addCreated($resource = null)
    {
        return $this->addOperation('created', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function addUpdated($resource = null)
    {
        return $this->addOperation('updated', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function addSaved($resource = null)
    {
        return $this->addOperation('saved', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function addDeleted($resource = null)
    {
        return $this->addOperation('deleted', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function preset($preset, $parameters = array())
    {
        $flash = false;

        if (\is_bool($parameters)) { /** @phpstan-ignore-line */
            $flash = $parameters;
            $parameters = array();
            @trigger_error('Since php-flasher/flasher v1.5: automatically flashing a preset is deprecated and will be removed in v2.0. You should use addPreset() or chain the preset call with flash() instead.', \E_USER_DEPRECATED);
        }

        $this->envelope->withStamp(new PresetStamp($preset, $parameters));

        if (false === $flash) {
            return $this;
        }

        return $this->flash(); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function operation($operation, $resource = null)
    {
        if ($resource instanceof ResourceInterface) {
            $type = $resource->getResourceType();
            $name = $resource->getResourceName();

            $resource = sprintf(
                '%s %s',
                $type,
                empty($name) ? '' : sprintf('"%s"', $name)
            );
        }

        $parameters = array(
            'resource' => $resource ?: 'resource',
        );

        return $this->preset($operation, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function created($resource = null)
    {
        return $this->operation('created', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function updated($resource = null)
    {
        return $this->operation('updated', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function saved($resource = null)
    {
        return $this->operation('saved', $resource);
    }

    /**
     * {@inheritdoc}
     */
    public function deleted($resource = null)
    {
        return $this->operation('deleted', $resource);
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
        $stamp = $this->envelope->get('Flasher\Prime\Stamp\HandlerStamp');

        if ($stamp instanceof HandlerStamp) {
            throw new \LogicException('You cannot change the handler of a notification once it has been set.');
        }

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

    /**
     * {@inheritdoc}
     */
    public function livewire(array $context = array())
    {
        @trigger_error(sprintf('Since php-flasher/flasher v1.0: Using %s method is deprecated and will be removed in v2.0. please use the builder methods directly.', __METHOD__), \E_USER_DEPRECATED);

        return $this;
    }
}
