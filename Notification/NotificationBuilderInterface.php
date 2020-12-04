<?php

namespace Flasher\Prime\Notification;

interface NotificationBuilderInterface
{
    /**
     * @param string      $type
     * @param string|null $message
     * @param array       $options
     *
     * @return NotificationBuilder
     */
    public function type($type, $message = null, array $options = array());

    /**
     * @param string $message
     *
     * @return NotificationBuilder
     */
    public function message($message);

    /**
     * @param array<string, mixed> $options
     * @param bool                 $merge
     *
     * @return NotificationBuilder
     */
    public function options($options, $merge = true);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return NotificationBuilder
     */
    public function option($name, $value);

    /**
     * @return NotificationInterface
     */
    public function getNotification();

    /**
     * @param string|null $message
     * @param array       $options
     *
     * @return self
     */
    public function success($message = null, array $options = array());

    /**
     * @param string|null $message
     * @param array       $options
     *
     * @return self
     */
    public function error($message = null, array $options = array());


    /**
     * @param string|null $message
     * @param array       $options
     *
     * @return self
     */
    public function info($message = null, array $options = array());

    /**
     * @param string|null $message
     * @param array       $options
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
}
