<?php

namespace Flasher\SweetAlert\Symfony;

use Flasher\SweetAlert\Symfony\DependencyInjection\FlasherSweetAlertExtension;
use Flasher\Symfony\Bridge\FlasherBundle;

class FlasherSweetAlertSymfonyBundle extends FlasherBundle
{
    protected function getFlasherContainerExtension()
    {
        return new FlasherSweetAlertExtension();
    }
}
