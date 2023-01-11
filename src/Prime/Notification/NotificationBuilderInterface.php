<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\StampInterface;
use Flasher\Prime\Translation\ResourceInterface;

interface NotificationBuilderInterface
{
    /**
     * @param string                           $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return Envelope
     */
    public function addSuccess($message, $title = null, array $options = array());

    /**
     * @param string                           $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return Envelope
     */
    public function addError($message, $title = null, array $options = array());

    /**
     * @param string                           $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return Envelope
     */
    public function addWarning($message, $title = null, array $options = array());

    /**
     * @param string                           $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return Envelope
     */
    public function addInfo($message, $title = null, array $options = array());

    /**
     * @param NotificationInterface|string     $type
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return Envelope
     */
    public function addFlash($type, $message, $title = null, array $options = array());

    /**
     * @param string                           $type
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function type($type, $message = null, $title = null, array $options = array());

    /**
     * @param string $message
     *
     * @return static
     */
    public function message($message);

    /**
     * @param string $title
     *
     * @return static
     */
    public function title($title);

    /**
     * @param array<string, mixed> $options
     * @param bool                 $merge
     *
     * @return static
     */
    public function options(array $options, $merge = true);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return static
     */
    public function option($name, $value);

    /**
     * @deprecated In php-flasher/flasher v2.0, the "success()" method will be an alias of "addSuccess()" method as it will immediately call the `->flash()` method. Use the "type('success')" method instead to avoid this breaking change.
     *
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function success($message = null, $title = null, array $options = array());

    /**
     * @deprecated In php-flasher/flasher v2.0, the "error()" method will be an alias of "addError()" method as it will immediately call the `->flash()` method. Use the "type('error')" method instead to avoid this breaking change.
     *
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function error($message = null, $title = null, array $options = array());

    /**
     * @deprecated In php-flasher/flasher v2.0, the "info()" method will be an alias of "addInfo()" method as it will immediately call the `->flash()` method. Use the "type('info')" method instead to avoid this breaking change.
     *
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function info($message = null, $title = null, array $options = array());

    /**
     * @deprecated In php-flasher/flasher v2.0, the "warning()" method will be an alias of "addWarning()" method as it will immediately call the `->flash()` method. Use the "type('warning')" method instead to avoid this breaking change.
     *
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function warning($message = null, $title = null, array $options = array());

    /**
     * @param bool|\Closure $condition
     *
     * @return static
     */
    public function when($condition);

    /**
     * @param bool|\Closure $condition
     *
     * @return static
     */
    public function unless($condition);

    /**
     * @param int $priority
     *
     * @return static
     */
    public function priority($priority);

    /**
     * @return static
     */
    public function keep();

    /**
     * @param int $amount
     *
     * @return static
     */
    public function hops($amount);

    /**
     * @param string $handler
     *
     * @return static
     */
    public function handler($handler);

    /**
     * @param mixed[] $context
     *
     * @return static
     */
    public function context(array $context);

    /**
     * @return static
     */
    public function withStamp(StampInterface $stamp);

    /**
     * @param StampInterface|StampInterface[] $stamps
     *
     * @return static
     */
    public function with($stamps = array());

    /**
     * @return static
     */
    public function now();

    /**
     * @param int $delay
     *
     * @return static
     */
    public function delay($delay);

    /**
     * @param array<string, mixed> $parameters
     * @param string|null          $locale
     *
     * @return static
     */
    public function translate($parameters = array(), $locale = null);

    /**
     * @param string               $preset
     * @param array<string, mixed> $parameters
     *
     * @return Envelope
     */
    public function addPreset($preset, $parameters = array());

    /**
     * @param string                        $operation
     * @param ResourceInterface|string|null $resource
     *
     * @return Envelope
     */
    public function addOperation($operation, $resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return Envelope
     */
    public function addCreated($resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return Envelope
     */
    public function addUpdated($resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return Envelope
     */
    public function addSaved($resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return Envelope
     */
    public function addDeleted($resource = null);

    /**
     * @deprecated In php-flasher/flasher v2.0, the "preset()" method will be an alias of "addPreset()" method as will immediately call the `->flash()` method. Use the "addPreset()" method instead to avoid this breaking change.
     *
     * @param string               $preset
     * @param array<string, mixed> $parameters
     *
     * @return static
     */
    public function preset($preset, $parameters = array());

    /**
     * @deprecated In php-flasher/flasher v2.0, the "operation()" method will be an alias of "addOperation()" method as will immediately call the `->flash()` method. Use the "addOperation()" method instead to avoid this breaking change.
     *
     * @param string                        $operation
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function operation($operation, $resource = null);

    /**
     * @deprecated In php-flasher/flasher v2.0, the "created()" method will be an alias of "addCreated()" method as will immediately call the `->flash()` method. Use the "addCreated()" method instead to avoid this breaking change.
     *
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function created($resource = null);

    /**
     * @deprecated In php-flasher/flasher v2.0, the "updated()" method will be an alias of "addUpdated()" method as will immediately call the `->flash()` method. Use the "addUpdated()" method instead to avoid this breaking change.
     *
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function updated($resource = null);

    /**
     * @deprecated In php-flasher/flasher v2.0, the "saved()" method will be an alias of "addSaved()" method as will immediately call the `->flash()` method. Use the "addSaved()" method instead to avoid this breaking change.
     *
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function saved($resource = null);

    /**
     * @deprecated In php-flasher/flasher v2.0, the "deleted()" method will be an alias of "addDeleted()" method as will immediately call the `->flash()` method. Use the "addDeleted()" method instead to avoid this breaking change.
     *
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function deleted($resource = null);

    /**
     * @param StampInterface[] $stamps
     *
     * @return Envelope
     */
    public function push(array $stamps = array());

    /**
     * @deprecated Since php-flasher/flasher v1.12: Using "flash()" method is deprecated and will be removed in v2.0. please use the "push()" method instead.
     *
     * @param StampInterface[] $stamps
     *
     * @return Envelope
     */
    public function flash(array $stamps = array());

    /**
     * @return Envelope
     */
    public function getEnvelope();

    /**
     * @deprecated Since php-flasher/flasher v1.0: Using livewire() method is deprecated and will be removed in v2.0. please use the builder methods directly.
     * @see https://php-flasher.io/docs/framework/livewire/
     *
     * @param array<string, mixed> $context
     *
     * @return static
     */
    public function livewire(array $context = array());
}
