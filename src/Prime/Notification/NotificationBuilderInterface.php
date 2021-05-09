<?php

namespace Flasher\Prime\Notification;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\StampInterface;

interface NotificationBuilderInterface
{
    /**
     * @param string $message
     *
     * @return Envelope
     */
    public function addSuccess($message, array $options = array());

    /**
     * @param string $message
     *
     * @return Envelope
     */
    public function addError($message, array $options = array());

    /**
     * @param string $message
     *
     * @return Envelope
     */
    public function addWarning($message, array $options = array());

    /**
     * @param string $message
     *
     * @return Envelope
     */
    public function addInfo($message, array $options = array());

    /**
     * @param string|NotificationInterface $type
     * @param string $message
     *
     * @return Envelope|mixed
     */
    public function addFlash($type, $message, array $options = array());

    /**
     * @param string      $type
     * @param string|null $message
     *
     * @return self
     */
    public function type($type, $message = null, array $options = array());

    /**
     * @param string $message
     *
     * @return self
     */
    public function message($message);

    /**
     * @param array<string, mixed> $options
     * @param bool                 $merge
     *
     * @return self
     */
    public function options($options, $merge = true);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return self
     */
    public function option($name, $value);

    /**
     * @param string|null $message
     *
     * @return self
     */
    public function success($message = null, array $options = array());

    /**
     * @param string|null $message
     *
     * @return self
     */
    public function error($message = null, array $options = array());

    /**
     * @param string|null $message
     *
     * @return self
     */
    public function info($message = null, array $options = array());

    /**
     * @param string|null $message
     *
     * @return self
     */
    public function warning($message = null, array $options = array());

    /**
     * @param int $priority
     *
     * @return self
     */
    public function priority($priority);

    /**
     * @return self
     */
    public function keep();

    /**
     * @param int $amount
     *
     * @return self
     */
    public function hops($amount);

    /**
     * @param string $handler
     *
     * @return self
     */
    public function handler($handler);

    /**
     * @return self
     */
    public function withStamp(StampInterface $stamp);

    /**
     * @param StampInterface[] $stamps
     *
     * @return self
     */
    public function with(array $stamps = array());

    /**
     * @return self
     */
    public function now();

    /**
     * @param int $delay
     *
     * @return self
     */
    public function delay($delay);

    /**
     * @param StampInterface[] $stamps
     *
     * @return Envelope
     */
    public function flash($stamps = array());

    /**
     * @return Envelope
     */
    public function getEnvelope();
}
