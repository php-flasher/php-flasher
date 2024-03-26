<?php

declare(strict_types=1);

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;

final class FlasherNotyBundle extends PluginBundle
{
    public function createPlugin(): PluginInterface
    {
        return new NotyPlugin();
    }
}
