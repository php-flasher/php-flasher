<?php

namespace Flasher\Prime\Factory;

use Flasher\Prime\Notification\Template;
use Flasher\Prime\Notification\TemplateBuilder;

/**
 * @mixin TemplateBuilder
 */
final class TemplateFactory extends NotificationFactory
{
    public function createNotificationBuilder()
    {
        return new TemplateBuilder(
            $this->getStorageManager(),
            new Template(),
            'template'
        );
    }
}
