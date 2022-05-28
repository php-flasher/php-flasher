<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class PnotifyBuilder extends NotificationBuilder
{
    public function warning($message = null, $title = null, array $options = array())
    {
        return $this->type('notice', $message, $title, $options);
    }

    /**
     * The notice's title.
     *
     * @param bool|string $title
     *
     * @return static
     */
    public function title($title)
    {
        $this->option('title', $title);

        return $this;
    }

    /**
     * Whether to escape the content of the title. (Not allow HTML.).
     *
     * @param bool $titleEscape
     *
     * @return static
     */
    public function titleEscape($titleEscape = true)
    {
        $this->option('title_escape', $titleEscape);

        return $this;
    }

    /**
     * The notice's text.
     *
     * @param string $text
     *
     * @return static
     */
    public function text($text)
    {
        $this->option('text', $text);

        return $this;
    }

    public function message($message)
    {
        parent::message($message);

        return $this->text($message);
    }

    /**
     * Whether to escape the content of the text. (Not allow HTML.).
     *
     * @param bool $textEscape
     *
     * @return static
     */
    public function textEscape($textEscape = true)
    {
        $this->option('text_escape', $textEscape);

        return $this;
    }

    /**
     * What styling classes to use. (Can be either "brighttheme", "bootstrap3", "fontawesome", or a custom style object.
     * See the source in the end of pnotify.js for the properties in a style object.).
     *
     * @param string $styling
     *
     * @return static
     */
    public function styling($styling)
    {
        $this->option('styling', $styling);

        return $this;
    }

    /**
     * Additional classes to be added to the notice. (For custom styling.).
     *
     * @param string $addClass
     *
     * @return static
     */
    public function addClass($addClass)
    {
        $this->option('addclass', $addClass);

        return $this;
    }

    /**
     * Class to be added to the notice for corner styling.
     *
     * @param string $cornerClass
     *
     * @return static
     */
    public function cornerClass($cornerClass)
    {
        $this->option('cornerclass', $cornerClass);

        return $this;
    }

    /**
     * Display the notice when it is created. Turn this off to add notifications to the history without displaying them.
     *
     * @param bool $autoDisplay
     *
     * @return static
     */
    public function autoDisplay($autoDisplay = true)
    {
        $this->option('auto_display', $autoDisplay);

        return $this;
    }

    /**
     * Width of the notice.
     *
     * @param int $width
     *
     * @return static
     */
    public function width($width)
    {
        $this->option('width', $width);

        return $this;
    }

    /**
     * Minimum height of the notice. It will expand to fit content.
     *
     * @param int $minHeight
     *
     * @return static
     */
    public function minHeight($minHeight)
    {
        $this->option('minHeight', $minHeight);

        return $this;
    }

    /**
     * Set icon to true to use the default icon for the selected style/type, false for no icon, or a string for your own
     * icon class.
     *
     * @param bool $icon
     *
     * @return static
     */
    public function icon($icon = true)
    {
        $this->option('icon', $icon);

        return $this;
    }

    /**
     * The animation to use when displaying and hiding the notice. "none" and "fade" are supported through CSS. Others
     * are supported through the Animate module and Animate.css.
     *
     * @param string $animation
     *
     * @return static
     */
    public function animation($animation)
    {
        $this->option('animation', $animation);

        return $this;
    }

    /**
     * Speed at which the notice animates in and out. "slow", "normal", or "fast". Respectively, 400ms, 250ms, 100ms.
     *
     * @param string $animateSpeed
     *
     * @return static
     */
    public function animateSpeed($animateSpeed)
    {
        $this->option('animate_speed', $animateSpeed);

        return $this;
    }

    /**
     * Display a drop shadow.
     *
     * @param bool $shadow
     *
     * @return static
     */
    public function shadow($shadow = true)
    {
        $this->option('shadow', $shadow);

        return $this;
    }

    /**
     * After a delay, remove the notice.
     *
     * @param bool $hide
     *
     * @return static
     */
    public function hide($hide = true)
    {
        $this->option('hide', $hide);

        return $this;
    }

    /**
     * Delay in milliseconds before the notice is removed.
     *
     * @param int $timer
     *
     * @return static
     */
    public function timer($timer)
    {
        $this->option('delay', $timer);

        return $this;
    }

    /**
     * Reset the hide timer if the mouse moves over the notice.
     *
     * @param bool $mouseReset
     *
     * @return static
     */
    public function mouseReset($mouseReset = true)
    {
        $this->option('mouse_reset', $mouseReset);

        return $this;
    }

    /**
     * Remove the notice's elements from the DOM after it is removed.
     *
     * @param bool $remove
     *
     * @return static
     */
    public function remove($remove = true)
    {
        $this->option('remove', $remove);

        return $this;
    }

    /**
     * Change new lines to br tags.
     *
     * @param bool $insertBrs
     *
     * @return static
     */
    public function insertBrs($insertBrs = true)
    {
        $this->option('insert_brs', $insertBrs);

        return $this;
    }

    /**
     * Whether to remove the notice from the global array when it is closed.
     *
     * @param bool $destroy
     *
     * @return static
     */
    public function destroy($destroy = true)
    {
        $this->option('destroy', $destroy);

        return $this;
    }

    /**
     * Desktop Module.
     *
     * @param string $desktop
     * @param mixed  $value
     *
     * @return static
     */
    public function desktop($desktop, $value)
    {
        $option = $this->getEnvelope()->getOption('desktop', array());
        $option[$desktop] = $value; // @phpstan-ignore-line

        $this->option('desktop', $option);

        return $this;
    }

    /**
     * Buttons Module.
     *
     * @param string $buttons
     * @param mixed  $value
     *
     * @return static
     */
    public function buttons($buttons, $value)
    {
        $option = $this->getEnvelope()->getOption('buttons', array());
        $option[$buttons] = $value; // @phpstan-ignore-line

        $this->option('buttons', $option);

        return $this;
    }

    /**
     * NonBlock Module.
     *
     * @param string $nonblock
     * @param mixed  $value
     *
     * @return static
     */
    public function nonblock($nonblock, $value)
    {
        $option = $this->getEnvelope()->getOption('nonblock', array());
        $option[$nonblock] = $value; // @phpstan-ignore-line

        $this->option('nonblock', $option);

        return $this;
    }

    /**
     * Mobile Module.
     *
     * @param string $mobile
     * @param mixed  $value
     *
     * @return static
     */
    public function mobile($mobile, $value)
    {
        $option = $this->getEnvelope()->getOption('mobile', array());
        $option[$mobile] = $value; // @phpstan-ignore-line

        $this->option('mobile', $option);

        return $this;
    }

    /**
     * Animate Module.
     *
     * @param string $animate
     * @param mixed  $value
     *
     * @return static
     */
    public function animate($animate, $value)
    {
        $option = $this->getEnvelope()->getOption('animate', array());
        $option[$animate] = $value; // @phpstan-ignore-line

        $this->option('animate', $option);

        return $this;
    }

    /**
     * Confirm Module.
     *
     * @param string $confirm
     * @param mixed  $value
     *
     * @return static
     */
    public function confirm($confirm, $value)
    {
        $option = $this->getEnvelope()->getOption('confirm', array());
        $option[$confirm] = $value; // @phpstan-ignore-line

        $this->option('confirm', $option);

        return $this;
    }

    /**
     * History Module.
     *
     * @param string $history
     * @param mixed  $value
     *
     * @return static
     */
    public function history($history, $value)
    {
        $option = $this->getEnvelope()->getOption('history', array());
        $option[$history] = $value; // @phpstan-ignore-line

        $this->option('history', $option);

        return $this;
    }
}
