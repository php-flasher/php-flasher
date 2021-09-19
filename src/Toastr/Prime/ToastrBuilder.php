<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @method self livewire(array $context = array())
 */
final class ToastrBuilder extends NotificationBuilder
{
    /**
     * @param string $title
     *
     * @return self
     */
    public function title($title)
    {
        $notification = $this->envelope->getNotification();
        $notification->setTitle(addslashes($title));

        return $this;
    }

    /**
     * Enable a close button
     *
     * @param bool $closeButton
     *
     * @return $this
     */
    public function closeButton($closeButton = true)
    {
        $this->option('closeButton', $closeButton);

        return $this;
    }

    /**
     * @param string $closeClass
     *
     * @return $this
     */
    public function closeClass($closeClass)
    {
        $this->option('closeClass', $closeClass);

        return $this;
    }

    /**
     * @param int $closeDuration
     *
     * @return $this
     */
    public function closeDuration($closeDuration)
    {
        $this->option('closeDuration', $closeDuration);

        return $this;
    }

    /**
     * @param string $closeEasing
     *
     * @return $this
     */
    public function closeEasing($closeEasing)
    {
        $this->option('closeEasing', $closeEasing);

        return $this;
    }

    /**
     * Override the close button's HTML.
     *
     * @param string $closeHtml
     *
     * @return $this
     */
    public function closeHtml($closeHtml)
    {
        $this->option('closeHtml', $closeHtml);

        return $this;
    }

    /**
     * @param string $closeMethod
     *
     * @return $this
     */
    public function closeMethod($closeMethod)
    {
        $this->option('closeMethod', $closeMethod);

        return $this;
    }

    /**
     * @param bool $closeOnHover
     *
     * @return $this
     */
    public function closeOnHover($closeOnHover = true)
    {
        $this->option('closeOnHover', $closeOnHover);

        return $this;
    }

    /**
     * @param string $containerId
     *
     * @return $this
     */
    public function containerId($containerId)
    {
        $this->option('containerId', $containerId);

        return $this;
    }

    /**
     * @param bool $debug
     *
     * @return $this
     */
    public function debug($debug = true)
    {
        $this->option('debug', $debug);

        return $this;
    }

    /**
     * In case you want to escape HTML characters in title and message
     *
     * @param bool $escapeHtml
     *
     * @return $this
     */
    public function escapeHtml($escapeHtml = true)
    {
        $this->option('escapeHtml', $escapeHtml);

        return $this;
    }

    /**
     * How long the toast will display after a user hovers over it
     *
     * @param int $extendedTimeOut
     *
     * @return $this
     */
    public function extendedTimeOut($extendedTimeOut)
    {
        $this->option('extendedTimeOut', $extendedTimeOut);

        return $this;
    }

    /**
     * Specifies the time during which the pop-up closes in ms
     *
     * @param int $hideDuration
     *
     * @return $this
     */
    public function hideDuration($hideDuration)
    {
        $this->option('hideDuration', $hideDuration);

        return $this;
    }

    /**
     * Indicates the entry transition of the pop-up
     *
     * @param string $hideEasing
     *
     * @return $this
     */
    public function hideEasing($hideEasing)
    {
        $this->option('hideEasing', $hideEasing);

        return $this;
    }

    /**
     * Indicates the opening animation of the pop-up
     *
     * @param string $hideMethod
     *
     * @return $this
     */
    public function hideMethod($hideMethod)
    {
        $this->option('hideMethod', $hideMethod);

        return $this;
    }

    /**
     * @param string $iconClass
     *
     * @return $this
     */
    public function iconClass($iconClass)
    {
        $this->option('iconClass', $iconClass);

        return $this;
    }

    /**
     * @param string $messageClass
     *
     * @return $this
     */
    public function messageClass($messageClass)
    {
        $this->option('messageClass', $messageClass);

        return $this;
    }

    /**
     * Show newest toast at bottom (top is default)
     *
     * @param bool $newestOnTop
     *
     * @return $this
     */
    public function newestOnTop($newestOnTop = true)
    {
        $this->option('newestOnTop', $newestOnTop);

        return $this;
    }

    /**
     * @param string $onHidden
     *
     * @return $this
     */
    public function onHidden($onHidden)
    {
        $this->option('onHidden', $onHidden);

        return $this;
    }

    /**
     * @param string $onShown
     *
     * @return $this
     */
    public function onShown($onShown)
    {
        $this->option('onShown', $onShown);

        return $this;
    }

    /**
     * @param string $positionClass
     *
     * @return $this
     */
    public function positionClass($positionClass)
    {
        $this->option('positionClass', $positionClass);

        return $this;
    }

    /**
     * Rather than having identical toasts stack, set the preventDuplicates property to true. Duplicates are matched to
     * the previous toast based on their message content.
     *
     * @param bool $preventDuplicates
     *
     * @return $this
     */
    public function preventDuplicates($preventDuplicates = true)
    {
        $this->option('preventDuplicates', $preventDuplicates);

        return $this;
    }

    /**
     * Visually indicate how long before a toast expires.
     *
     * @param bool $progressBar
     *
     * @return $this
     */
    public function progressBar($progressBar = true)
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    /**
     * @param string $progressClass
     *
     * @return $this
     */
    public function progressClass($progressClass)
    {
        $this->option('progressClass', $progressClass);

        return $this;
    }

    /**
     * Flip the toastr to be displayed properly for right-to-left languages.
     *
     * @param bool $rtl
     *
     * @return $this
     */
    public function rtl($rtl = true)
    {
        $this->option('rtl', $rtl);

        return $this;
    }

    /**
     * Specifies the time during which the pop-up opens in ms
     *
     * @param int $showDuration
     *
     * @return $this
     */
    public function showDuration($showDuration)
    {
        $this->option('showDuration', $showDuration);

        return $this;
    }

    /**
     * Indicates the entry transition of the pop-up
     *
     * @param string $showEasing
     *
     * @return $this
     */
    public function showEasing($showEasing)
    {
        $this->option('showEasing', $showEasing);

        return $this;
    }

    /**
     * Indicates the opening animation of the pop-up
     *
     * @param string $showMethod
     *
     * @return $this
     */
    public function showMethod($showMethod)
    {
        $this->option('showMethod', $showMethod);

        return $this;
    }

    /**
     * Forces the user to validate the pop-up before closing
     *
     * @param bool $tapToDismiss
     *
     * @return $this
     */
    public function tapToDismiss($tapToDismiss = true)
    {
        $this->option('tapToDismiss', $tapToDismiss);

        return $this;
    }

    /**
     * @param string $target
     *
     * @return $this
     */
    public function target($target)
    {
        $this->option('target', $target);

        return $this;
    }

    /**
     * How long the toast will display without user interaction
     *
     * @param int  $timeOut
     * @param int $extendedTimeOut
     *
     * @return $this
     */
    public function timeOut($timeOut, $extendedTimeOut = null)
    {
        $this->option('timeOut', $timeOut);

        if (null !== $extendedTimeOut) {
            $this->extendedTimeOut($extendedTimeOut);
        }

        return $this;
    }

    /**
     * @param string $titleClass
     *
     * @return $this
     */
    public function titleClass($titleClass)
    {
        $this->option('titleClass', $titleClass);

        return $this;
    }

    /**
     * @param string $toastClass
     *
     * @return $this
     */
    public function toastClass($toastClass)
    {
        $this->option('toastClass', $toastClass);

        return $this;
    }

    /**
     * Prevent from Auto Hiding
     *
     * @return $this
     */
    public function persistent()
    {
        $this->timeOut(0);
        $this->extendedTimeOut(0);

        return $this;
    }
}
