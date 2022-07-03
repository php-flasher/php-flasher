<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Notification;

interface NotificationInterface
{
    const SUCCESS = 'success';
    const ERROR = 'error';
    const INFO = 'info';
    const WARNING = 'warning';

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @param string|null $type
     *
     * @return static
     */
    public function setType($type);

    /**
     * @return string|null
     */
    public function getMessage();

    /**
     * @param string|null $message
     *
     * @return static
     */
    public function setMessage($message);

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @param string|null $title
     *
     * @return static
     */
    public function setTitle($title);

    /**
     * @return array<string, mixed>
     */
    public function getOptions();

    /**
     * @param array<string, mixed> $options
     *
     * @return static
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
     * @return static
     */
    public function setOption($name, $value);

    /**
     * @param string $name
     *
     * @return static
     */
    public function unsetOption($name);

    /**
     * @return array<string, mixed>
     */
    public function toArray();
}
