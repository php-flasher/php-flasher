<?php

declare(strict_types=1);

namespace Flasher\Pnotify\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Pnotify\Prime\PnotifyPlugin;

final class FlasherPnotifyPluginServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): PnotifyPlugin
    {
        return new PnotifyPlugin();
    }
}
