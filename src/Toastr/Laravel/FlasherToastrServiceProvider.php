<?php

declare(strict_types=1);

namespace Flasher\Toastr\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): ToastrPlugin
    {
        return new ToastrPlugin();
    }
}
