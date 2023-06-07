<?php

declare(strict_types=1);

namespace Flasher\Pnotify\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Pnotify\Prime\PnotifyPlugin;

final class FlasherPnotifyServiceProvider extends ServiceProvider
{
    public function createPlugin(): PnotifyPlugin
    {
        return new PnotifyPlugin();
    }
}
