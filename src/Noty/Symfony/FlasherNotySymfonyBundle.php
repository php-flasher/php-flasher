<?php

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Prime\NotyPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherNotySymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin()
    {
        return new NotyPlugin();
    }
}
