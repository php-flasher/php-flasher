<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class NotyBuilder extends NotificationBuilder
{
    /**
     * @param string $text
     *
     * @return NotyBuilder
     */
    public function text($text)
    {
        return $this->message($text);
    }

    /**
     * @param string  $message
     * @param array $options
     *
     * @return NotyBuilder
     */
    public function alert($message = null, array $options = array())
    {
        return $this->type('alert', $message, $options);
    }

    /**
     * @param string $layout
     *
     * @return $this
     */
    public function layout($layout)
    {
        $this->option('layout', $layout);

        return $this;
    }

    /**
     * @param string $theme
     *
     * @return $this
     */
    public function theme($theme)
    {
        $this->option('theme', $theme);

        return $this;
    }

    /**
     * @param int|bool $timeout
     *
     * @return $this
     */
    public function timeout($timeout)
    {
        $this->option('timeout', $timeout);

        return $this;
    }

    /**
     * @param bool $progressBar
     *
     * @return $this
     */
    public function progressBar($progressBar = false)
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * @param array $closeWith
     *
     * @return $this
     */
    public function closeWith($closeWith)
    {
        $this->option('closeWith', $closeWith);

        return $this;
    }

    /**
     * @param string $animation
     * @param string $effect
     *
     * @return $this
     */
    public function animation($animation, $effect)
    {
        $this->option('animation.'.$animation, $effect);

        return $this;
    }

    /**
     * @param string $option
     * @param mixed $value
     *
     * @return $this
     */
    public function sounds($option, $value)
    {
        $this->option('sounds.'.$option, $value);

        return $this;
    }

    /**
     * @param bool $modal
     *
     * @return $this
     */
    public function modal($modal = true)
    {
        $this->option('modal', $modal);

        return $this;
    }

    /**
     * @param bool $force
     *
     * @return $this
     */
    public function force($force = true)
    {
        $this->option('force', $force);

        return $this;
    }

    /**
     * @param string|bool $killer
     *
     * @return $this
     */
    public function killer($killer)
    {
        $this->option('killer', $killer);

        return $this;
    }

    /**
     * @param string|bool $container
     *
     * @return $this
     */
    public function container($container)
    {
        $this->option('container', $container);

        return $this;
    }

    /**
     * @param array $buttons
     *
     * @return $this
     */
    public function buttons($buttons)
    {
        $this->option('buttons', $buttons);

        return $this;
    }
}
