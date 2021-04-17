<?php

namespace Flasher\SweetAlert\Symfony;

use Flasher\SweetAlert\Symfony\DependencyInjection\FlasherSweetAlertExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlasherSweetAlertSymfonyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new FlasherSweetAlertExtension();
    }
}
