<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime\Notifier;

use Flasher\Cli\Prime\Notification;
use Flasher\Cli\Prime\NotifyInterface;
use Flasher\Cli\Prime\System\Path;
use Flasher\Cli\Prime\System\Program;
use Flasher\Prime\Notification\NotificationInterface;

abstract class BaseNotifier implements NotifyInterface
{
    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * @return string|null
     */
    public function getBinary()
    {
        return null;
    }

    /**
     * @return string|string[]
     */
    public function getBinaryPaths()
    {
        return array();
    }

    /**
     * @return string|null
     */
    public function getProgram()
    {
        if (Program::exist($this->getBinary())) {
            return $this->getBinary();
        }

        foreach ((array) $this->getBinaryPaths() as $path) {
            $path = Path::realpath($path);

            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function success($message, $title = null, $options = array())
    {
        $this->type(NotificationInterface::SUCCESS, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, $title = null, $options = array())
    {
        $this->type(NotificationInterface::INFO, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, $title = null, $options = array())
    {
        $this->type(NotificationInterface::ERROR, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, $title = null, $options = array())
    {
        $this->type(NotificationInterface::WARNING, $message, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function type($type, $message, $title = null, $options = array())
    {
        $notification = new Notification($message, $title, null, $type, $options);

        $this->send($notification);
    }
}
