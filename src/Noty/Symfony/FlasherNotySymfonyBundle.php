<?php

declare(strict_types=1);

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Symfony\Support\Bundle;

final class FlasherNotySymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin(): NotyPlugin
    {
        return new NotyPlugin();
    }
}
