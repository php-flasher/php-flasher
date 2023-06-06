<?php

namespace Flasher\Pnotify\Symfony;

use Flasher\Pnotify\Prime\PnotifyPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherPnotifySymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin()
    {
        return new PnotifyPlugin();
    }
}
