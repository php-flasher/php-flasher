<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Noty\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class NotyBuilder extends NotificationBuilder
{
    /**
     * This string can contain HTML too. But be careful and don't pass user inputs to this parameter.
     *
     * @param string $text
     *
     * @return static
     */
    public function text($text)
    {
        return $this->message($text);
    }

    /**
     * @param string               $message
     * @param array<string, mixed> $options
     *
     * @return static
     */
    public function alert($message = null, array $options = array())
    {
        return $this->type('alert', $message, $options);
    }

    /**
     * top, topLeft, topCenter, topRight, center, centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight
     * - ClassName generator uses this value → noty_layout__${layout}.
     *
     * @param string $layout
     *
     * @return static
     */
    public function layout($layout)
    {
        $this->option('layout', $layout);

        return $this;
    }

    /**
     * relax, mint, metroui - ClassName generator uses this value → noty_theme__${theme}.
     *
     * @param string $theme
     *
     * @return static
     */
    public function theme($theme)
    {
        $this->option('theme', $theme);

        return $this;
    }

    /**
     * false, 1000, 3000, 3500, etc. Delay for closing event in milliseconds (ms). Set 'false' for sticky notifications.
     *
     * @param bool|int $timeout
     *
     * @return static
     */
    public function timeout($timeout)
    {
        $this->option('timeout', $timeout);

        return $this;
    }

    /**
     * true, false - Displays a progress bar if timeout is not false.
     *
     * @param bool $progressBar
     *
     * @return static
     */
    public function progressBar($progressBar = false)
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * click, button.
     *
     * @param array<string>|string $closeWith
     *
     * @return static
     */
    public function closeWith($closeWith)
    {
        $this->option('closeWith', (array) $closeWith);

        return $this;
    }

    /**
     * If string, assumed to be CSS class name. If null, no animation at all. If function, runs the function. (v3.0.1+)
     * You can use animate.css class names or your custom css animations as well.
     *
     * @param string $animation
     * @param string $effect
     *
     * @return static
     */
    public function animation($animation, $effect)
    {
        $this->option('animation.'.$animation, $effect);

        return $this;
    }

    /**
     * @param string $option
     * @param mixed  $value
     *
     * @return static
     */
    public function sounds($option, $value)
    {
        $this->option('sounds.'.$option, $value);

        return $this;
    }

    /**
     * @param string $option
     * @param mixed  $docTitle
     *
     * @return static
     */
    public function docTitle($option, $docTitle)
    {
        $this->option('docTitle'.$option, $docTitle);

        return $this;
    }

    /**
     * @param bool $modal
     *
     * @return static
     */
    public function modal($modal = true)
    {
        $this->option('modal', $modal);

        return $this;
    }

    /**
     * You can use this id with querySelectors. Generated automatically if false.
     *
     * @param bool|string $id
     *
     * @return static
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function id($id)
    {
        $this->option('id', $id);

        return $this;
    }

    /**
     * DOM insert method depends on this parameter. If false uses append, if true uses prepend.
     *
     * @param bool $force
     *
     * @return static
     */
    public function force($force = true)
    {
        $this->option('force', $force);

        return $this;
    }

    /**
     * @param string $queue
     *
     * @return static
     */
    public function queue($queue)
    {
        $this->option('queue', $queue);

        return $this;
    }

    /**
     * If true closes all visible notifications and shows itself. If string(queueName) closes all visible notification
     * on this queue and shows itself.
     *
     * @param bool|string $killer
     *
     * @return static
     */
    public function killer($killer)
    {
        $this->option('killer', $killer);

        return $this;
    }

    /**
     * Custom container selector string. Like '.my-custom-container'. Layout parameter will be ignored.
     *
     * @param bool|string $container
     *
     * @return static
     */
    public function container($container)
    {
        $this->option('container', $container);

        return $this;
    }

    /**
     * An array of Noty.button, for creating confirmation dialogs.
     *
     * @param array<string> $buttons
     *
     * @return static
     */
    public function buttons($buttons)
    {
        $this->option('buttons', $buttons);

        return $this;
    }

    /**
     * If true Noty uses PageVisibility API to handle timeout. To ensure that users do not miss their notifications.
     *
     * @param bool $visibilityControl
     *
     * @return static
     */
    public function visibilityControl($visibilityControl)
    {
        $this->option('visibilityControl', $visibilityControl);

        return $this;
    }
}
