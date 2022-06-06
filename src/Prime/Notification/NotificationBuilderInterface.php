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
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function success($message = null, $title = null, array $options = array());

    /**
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function error($message = null, $title = null, array $options = array());

    /**
     * @param string|null                      $message
     * @param array<string, mixed>|string|null $title
     * @param array<string, mixed>             $options
     *
     * @return static
     */
    public function info($message = null, $title = null, array $options = array());

    /**
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
     * @param string               $preset
     * @param array<string, mixed> $parameters
     *
     * @return static
     */
    public function preset($preset, $parameters = array());

    /**
     * @param string                        $operation
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function operation($operation, $resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function created($resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function updated($resource = null);

    /**
     * @param ResourceInterface|string|null $resource
     *
     * @return static
     */
    public function saved($resource = null);

    /**
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
