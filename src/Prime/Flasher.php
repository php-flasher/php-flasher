<?php

namespace Flasher\Prime;

use Flasher\Prime\Manager\AbstractManager;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Notification\NotificationInterface;
use Flasher\Prime\Stamp\StampInterface;

/**
 * @method NotificationBuilderInterface type($type, $message = null, array $options = array())
 * @method NotificationBuilderInterface message($message)
 * @method NotificationBuilderInterface options($options)
 * @method NotificationBuilderInterface setOption($name, $value)
 * @method NotificationBuilderInterface unsetOption($name)
 * @method NotificationBuilderInterface handler(string $handler)
 * @method NotificationBuilderInterface with(StampInterface[] $stamps)
 * @method NotificationBuilderInterface withStamp(StampInterface $stamp)
 * @method NotificationBuilderInterface priority($priority)
 * @method NotificationBuilderInterface hops($amount)
 * @method NotificationBuilderInterface keep()
 * @method NotificationBuilderInterface success($message = null, array $options = array())
 * @method NotificationBuilderInterface error($message = null, array $options = array())
 * @method NotificationBuilderInterface info($message = null, array $options = array())
 * @method NotificationBuilderInterface warning($message = null, array $options = array())
 * @method Envelope flash(StampInterface[] $stamps)
 * @method Envelope addFlash(string|Envelope $type, string $message = null, array $options = array())
 * @method Envelope addSuccess(string $message = null, array $options = array())
 * @method Envelope addError(string $message = null, array $options = array())
 * @method Envelope addWarning(string $message = null, array $options = array())
 * @method Envelope addInfo(string $message = null, array $options = array())
 * @method NotificationInterface getNotification()
 * @method NotificationInterface getEnvelope()
 */
final class Flasher extends AbstractManager implements FlasherInterface
{
    public function getDefaultDriver()
    {
        return $this->config->get('default');
    }
}
