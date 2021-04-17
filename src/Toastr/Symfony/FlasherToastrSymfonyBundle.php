<?php

namespace Flasher\Toastr\Symfony;

use Flasher\Toastr\Symfony\DependencyInjection\FlasherToastrExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlasherToastrSymfonyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new FlasherToastrExtension();
    }
}
