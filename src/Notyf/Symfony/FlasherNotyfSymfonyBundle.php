<?php

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherNotyfSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin()
    {
        return new NotyfPlugin();
    }
}
