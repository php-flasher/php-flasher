<?php

namespace Flasher\Cli\Prime;

/**
 * @mixin CliNotificationBuilder
 */
interface CliFlasherInterface
{
    public function render(array $criteria = array(), $presenter = 'html', array $context = array());
}
