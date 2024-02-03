<?php

declare(strict_types=1);

namespace Flasher\Toastr\Symfony;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundle;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrBundle extends PluginBundle
{
    public function createPlugin(): PluginInterface
    {
        return new ToastrPlugin();
    }
}
