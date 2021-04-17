<?php

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Symfony\DependencyInjection\FlasherNotyfExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlasherNotyfSymfonyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new FlasherNotyfExtension();
    }
}
