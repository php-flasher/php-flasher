<?php

namespace Flasher\Pnotify\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Pnotify\Prime\PnotifyPlugin;

final class FlasherPnotifyServiceProvider extends ServiceProvider
{
    public function createPlugin()
    {
        return new PnotifyPlugin();
    }
}
