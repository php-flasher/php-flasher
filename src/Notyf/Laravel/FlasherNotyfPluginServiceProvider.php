<?php

declare(strict_types=1);

namespace Flasher\Notyf\Laravel;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Notyf\Prime\NotyfPlugin;

final class FlasherNotyfPluginServiceProvider extends PluginServiceProvider
{
    public function createPlugin(): NotyfPlugin
    {
        return new NotyfPlugin();
    }
}
