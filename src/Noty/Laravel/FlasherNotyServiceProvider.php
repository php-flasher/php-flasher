<?php

declare(strict_types=1);

namespace Flasher\Noty\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Noty\Prime\NotyPlugin;

final class FlasherNotyServiceProvider extends ServiceProvider
{
    public function createPlugin(): NotyPlugin
    {
        return new NotyPlugin();
    }
}
