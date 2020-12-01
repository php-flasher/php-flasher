<?php

namespace Flasher\Prime\TestsNotification;

interface NotificationBuilderInterface
{
    /**
     * @param string      $type
     * @param string|null $message
     * @param array       $options
     *
     * @return \Flasher\Prime\TestsNotification\NotificationBuilder
     */
    public function type($type, $message = null, array $options = array());

    /**
     * @param string $message
     *
     * @return \Flasher\Prime\TestsNotification\NotificationBuilder
     */
    public function message($message);

    /**
     * @param array<string, mixed> $options
     * @param bool                 $merge
     *
     * @return \Flasher\Prime\TestsNotification\NotificationBuilder
     */
    public function options($options, $merge = true);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return \Flasher\Prime\TestsNotification\NotificationBuilder
     */
    public function option($name, $value);

    /**
     * @return \Flasher\Prime\TestsNotification\NotificationInterface
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
}
