<?php

namespace Flasher\Toastr\Symfony;

use Flasher\Symfony\Bridge\FlasherBundle;
use Flasher\Toastr\Symfony\DependencyInjection\FlasherToastrExtension;

class FlasherToastrSymfonyBundle extends FlasherBundle
{
    protected function getFlasherContainerExtension()
    {
        return new FlasherToastrExtension();
    }
}
