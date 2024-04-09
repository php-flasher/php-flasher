<?php

declare(strict_types=1);

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;

final class FlasherNotySymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin(): PluginInterface
    {
        return new NotyPlugin();
    }
}
