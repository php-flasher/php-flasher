<?php

namespace Flasher\Toastr\Symfony;

use Flasher\Symfony\Support\Bundle;
use Flasher\Toastr\Prime\ToastrPlugin;

final class FlasherToastrSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin()
    {
        return new ToastrPlugin();
    }
}
