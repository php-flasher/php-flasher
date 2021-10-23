<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Template;
use Flasher\Prime\Notification\TemplateBuilder;

/**
 * @mixin TemplateBuilder
 */
final class TemplateFactory extends NotificationFactory
{
    private $handler = 'template';

    public function createNotificationBuilder()
    {
        return new TemplateBuilder(
            $this->getStorageManager(),
            new Template(),
            $this->getHandler()
        );
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function setHandler($handler)
    {
        $this->handler = $handler;
    }
}
