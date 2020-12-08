<?php

namespace Flasher\Prime;

use Flasher\Prime\Manager\AbstractManager;
use Flasher\Prime\Notification\NotificationBuilderInterface;

/**
 * @mixin NotificationBuilderInterface
 */
final class Flasher extends AbstractManager implements FlasherInterface
{
    public function getDefaultDriver()
    {
        return $this->config->get('default');
    }
}
