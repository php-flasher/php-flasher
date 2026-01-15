<?php

declare(strict_types=1);

namespace Flasher\Toastr\Symfony;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrSymfonyBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin(): PluginInterface
    {
        return new ToastrPlugin();
    }
}
