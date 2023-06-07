<?php

declare(strict_types=1);

namespace Flasher\Toastr\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrServiceProvider extends ServiceProvider
{
    public function createPlugin(): ToastrPlugin
    {
        return new ToastrPlugin();
    }
}
