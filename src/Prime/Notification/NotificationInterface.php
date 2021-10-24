<?php

namespace Flasher\Prime\Notification;

interface NotificationInterface
{
    const TYPE_SUCCESS = 'success';

    const TYPE_ERROR = 'error';

    const TYPE_INFO = 'info';

    const TYPE_WARNING = 'warning';

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @param string $message
     *
     * @return void
     */
    public function setMessage($message);

    /**
     * @return array<string, mixed>
     */
    public function getOptions();

    /**
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function setOptions(array $options);

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getOption($name, $default = null);

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setOption($name, $value);

    /**
     * @param string $name
     *
     * @return void
     */
    public function unsetOption($name);

    /**
     * @return array<string, mixed>
     */
    public function toArray();
}
