<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Notification\NotificationBuilder;

/**
 * @method Toastr getNotification()
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
        $notification->setTitle($title);

        return $this;
    }

    /**
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
     * @param int $timeOut
     *
     * @return $this
     */
    public function timeOut($timeOut)
    {
        $this->option('timeOut', $timeOut);
    
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
}
