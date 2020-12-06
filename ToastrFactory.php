<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Factory\AbstractFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Stamp\StampInterface;

/**
 * @method ToastrBuilder type(string $type, string $message = null, array $options = array())
 * @method ToastrBuilder message(string $message)
 * @method ToastrBuilder options(array $options, bool $merge = true)
 * @method ToastrBuilder setOption(string $name, $value)
 * @method ToastrBuilder unsetOption(string $name)
 * @method ToastrBuilder priority(int $priority)
 * @method ToastrBuilder handler(string $handler)
 * @method ToastrBuilder with(StampInterface[] $stamps)
 * @method ToastrBuilder withStamp(StampInterface $stamp)
 * @method ToastrBuilder hops(int $amount)
 * @method ToastrBuilder keep()
 * @method ToastrBuilder success(string $message = null, array $options = array())
 * @method ToastrBuilder error(string $message = null, array $options = array())
 * @method ToastrBuilder info(string $message = null, array $options = array())
 * @method ToastrBuilder warning(string $message = null, array $options = array())
 * @method ToastrBuilder title(string $title)
 * @method ToastrBuilder closeButton(bool $closeButton = true)
 * @method ToastrBuilder closeClass(string $closeClass)
 * @method ToastrBuilder closeDuration(int $closeDuration)
 * @method ToastrBuilder closeEasing(string $closeEasing)
 * @method ToastrBuilder closeHtml(string $closeHtml)
 * @method ToastrBuilder closeMethod(string $closeMethod)
 * @method ToastrBuilder closeOnHover(bool $closeOnHover = true)
 * @method ToastrBuilder containerId(string $containerId)
 * @method ToastrBuilder debug(bool $debug = true)
 * @method ToastrBuilder escapeHtml(bool $escapeHtml = true)
 * @method ToastrBuilder extendedTimeOut(int $extendedTimeOut)
 * @method ToastrBuilder hideDuration(int $hideDuration)
 * @method ToastrBuilder hideEasing(string $hideEasing)
 * @method ToastrBuilder hideMethod(string $hideMethod)
 * @method ToastrBuilder iconClass(string $iconClass)
 * @method ToastrBuilder messageClass(string $messageClass)
 * @method ToastrBuilder newestOnTop(bool $newestOnTop = true)
 * @method ToastrBuilder onHidden(string $onHidden)
 * @method ToastrBuilder onShown(string $onShown)
 * @method ToastrBuilder positionClass(string $positionClass)
 * @method ToastrBuilder preventDuplicates(bool $preventDuplicates = true)
 * @method ToastrBuilder progressBar(bool $progressBar = true)
 * @method ToastrBuilder progressClass(string $progressClass)
 * @method ToastrBuilder rtl(bool $rtl = true)
 * @method ToastrBuilder showDuration(int $showDuration)
 * @method ToastrBuilder showEasing(string $showEasing)
 * @method ToastrBuilder showMethod(string $showMethod)
 * @method ToastrBuilder tapToDismiss(bool $tapToDismiss = true)
 * @method ToastrBuilder target(string $target)
 * @method ToastrBuilder timeOut(int $timeOut)
 * @method ToastrBuilder titleClass(string $titleClass)
 * @method ToastrBuilder toastClass(string $toastClass)
 */
final class ToastrFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotification()
    {
        return new Toastr();
    }

    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new ToastrBuilder($this->getEventDispatcher(), $this->createNotification(), 'toastr');
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'toastr'));
    }
}
