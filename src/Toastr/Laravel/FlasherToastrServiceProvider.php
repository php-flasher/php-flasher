<?php

namespace Flasher\Toastr\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrServiceProvider extends ServiceProvider
{
    public function createPlugin()
    {
        return new ToastrPlugin();
    }
}
