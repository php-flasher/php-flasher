<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

final class ToastrBuilder extends NotificationBuilder
{
    /**
     * Enable a close button.
     */
    public function closeButton(bool $closeButton = true): self
    {
        $this->option('closeButton', $closeButton);

        return $this;
    }

    public function closeClass(string $closeClass): self
    {
        $this->option('closeClass', $closeClass);

        return $this;
    }

    public function closeDuration(int $closeDuration): self
    {
        $this->option('closeDuration', $closeDuration);

        return $this;
    }

    public function closeEasing(string $closeEasing): self
    {
        $this->option('closeEasing', $closeEasing);

        return $this;
    }

    /**
     * Override the close button's HTML.
     */
    public function closeHtml(string $closeHtml): self
    {
        $this->option('closeHtml', $closeHtml);

        return $this;
    }

    public function closeMethod(string $closeMethod): self
    {
        $this->option('closeMethod', $closeMethod);

        return $this;
    }

    public function closeOnHover(bool $closeOnHover = true): self
    {
        $this->option('closeOnHover', $closeOnHover);

        return $this;
    }

    public function containerId(string $containerId): self
    {
        $this->option('containerId', $containerId);

        return $this;
    }

    public function debug(bool $debug = true): self
    {
        $this->option('debug', $debug);

        return $this;
    }

    /**
     * In case you want to escape HTML characters in title and message.
     */
    public function escapeHtml(bool $escapeHtml = true): self
    {
        $this->option('escapeHtml', $escapeHtml);

        return $this;
    }

    /**
     * How long the toast will display after a user hovers over it.
     */
    public function extendedTimeOut(int $extendedTimeOut): self
    {
        $this->option('extendedTimeOut', $extendedTimeOut);

        return $this;
    }

    /**
     * Specifies the time during which the pop-up closes in ms.
     */
    public function hideDuration(int $hideDuration): self
    {
        $this->option('hideDuration', $hideDuration);

        return $this;
    }

    /**
     * @param string $hideEasing
     *
     * Indicates the entry transition of the pop-up
     */
    public function hideEasing(string $hideEasing): self
    {
        $this->option('hideEasing', $hideEasing);

        return $this;
    }

    /**
     * @param string $hideMethod
     *
     * Indicates the opening animation of the pop-up
     */
    public function hideMethod(string $hideMethod): self
    {
        $this->option('hideMethod', $hideMethod);

        return $this;
    }

    public function iconClass(string $iconClass): self
    {
        $this->option('iconClass', $iconClass);

        return $this;
    }

    public function messageClass(string $messageClass): self
    {
        $this->option('messageClass', $messageClass);

        return $this;
    }

    /**
     * Show newest toast at bottom (top is default).
     */
    public function newestOnTop(bool $newestOnTop = true): self
    {
        $this->option('newestOnTop', $newestOnTop);

        return $this;
    }

    public function onHidden(string $onHidden): self
    {
        $this->option('onHidden', $onHidden);

        return $this;
    }

    public function onShown(string $onShown): self
    {
        $this->option('onShown', $onShown);

        return $this;
    }

    /**
     * @param "toast-top-right"|"toast-top-center"|"toast-bottom-center"|"toast-top-full-width"|"toast-bottom-full-width"|"toast-top-left"|"toast-bottom-right"|"toast-bottom-left" $positionClass
     */
    public function positionClass(string $positionClass): self
    {
        $this->option('positionClass', $positionClass);

        return $this;
    }

    /**
     * Rather than having identical toasts stack, set the preventDuplicates property to true. Duplicates are matched to
     * the previous toast based on their message content.
     */
    public function preventDuplicates(bool $preventDuplicates = true): self
    {
        $this->option('preventDuplicates', $preventDuplicates);

        return $this;
    }

    /**
     * Visually indicate how long before a toast expires.
     */
    public function progressBar(bool $progressBar = true): self
    {
        $this->option('progressBar', $progressBar);

        return $this;
    }

    public function progressClass(string $progressClass): self
    {
        $this->option('progressClass', $progressClass);

        return $this;
    }

    /**
     * Flip the toastr to be displayed properly for right-to-left languages.
     */
    public function rtl(bool $rtl = true): self
    {
        $this->option('rtl', $rtl);

        return $this;
    }

    /**
     * Specifies the time during which the pop-up opens in ms.
     */
    public function showDuration(int $showDuration): self
    {
        $this->option('showDuration', $showDuration);

        return $this;
    }

    /**
     * @param string $showEasing
     *
     * Indicates the entry transition of the pop-up
     */
    public function showEasing(string $showEasing): self
    {
        $this->option('showEasing', $showEasing);

        return $this;
    }

    /**
     * @param string $showMethod
     *
     * Indicates the opening animation of the pop-up
     */
    public function showMethod(string $showMethod): self
    {
        $this->option('showMethod', $showMethod);

        return $this;
    }

    /**
     * Forces the user to validate the pop-up before closing.
     */
    public function tapToDismiss(bool $tapToDismiss = true): self
    {
        $this->option('tapToDismiss', $tapToDismiss);

        return $this;
    }

    public function target(string $target): self
    {
        $this->option('target', $target);

        return $this;
    }

    /**
     * How long the toast will display without user interaction.
     */
    public function timeOut(int $timeOut, ?int $extendedTimeOut = null): self
    {
        $this->option('timeOut', $timeOut);

        if (null !== $extendedTimeOut) {
            $this->extendedTimeOut($extendedTimeOut);
        }

        return $this;
    }

    public function titleClass(string $titleClass): self
    {
        $this->option('titleClass', $titleClass);

        return $this;
    }

    public function toastClass(string $toastClass): self
    {
        $this->option('toastClass', $toastClass);

        return $this;
    }

    /**
     * Prevent from Auto Hiding.
     */
    public function persistent(): self
    {
        $this->timeOut(0);
        $this->extendedTimeOut(0);

        return $this;
    }
}
