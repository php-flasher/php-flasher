<?php

namespace Flasher\SweetAlert\Symfony;

use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\Symfony\Support\Bundle;

class FlasherSweetAlertSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin()
    {
        return new SweetAlertPlugin();
    }
}
