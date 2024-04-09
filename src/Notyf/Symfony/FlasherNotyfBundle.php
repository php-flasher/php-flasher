<?php

declare(strict_types=1);

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;

final class FlasherNotyfBundle extends PluginBundle
{
    public function createPlugin(): PluginInterface
    {
        return new NotyfPlugin();
    }
}
