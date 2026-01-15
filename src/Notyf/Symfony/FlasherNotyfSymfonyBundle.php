<?php

declare(strict_types=1);

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;

final class FlasherNotyfSymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin(): PluginInterface
    {
        return new NotyfPlugin();
    }
}
