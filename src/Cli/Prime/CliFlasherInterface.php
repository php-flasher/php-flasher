<?php

namespace Flasher\Cli\Prime;

/**
 * @mixin CliNotificationBuilder
 */
interface CliFlasherInterface
{
    public function render(array $criteria = array(), $merge = true);
}
