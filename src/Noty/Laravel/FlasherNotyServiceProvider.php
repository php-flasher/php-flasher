<?php

declare(strict_types=1);

namespace Flasher\Noty\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Noty\Prime\NotyPlugin;

final class FlasherNotyServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): NotyPlugin
    {
        return new NotyPlugin();
    }
}
