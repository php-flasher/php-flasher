<?php

declare(strict_types=1);

namespace Flasher\Notyf\Laravel;

use Flasher\Laravel\Support\ServiceProvider;
use Flasher\Notyf\Prime\NotyfPlugin;

final class FlasherNotyfServiceProvider extends ServiceProvider
{
    public function createPlugin(): NotyfPlugin
    {
        return new NotyfPlugin();
    }
}
