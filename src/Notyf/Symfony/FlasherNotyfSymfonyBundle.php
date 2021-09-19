<?php

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Symfony\DependencyInjection\FlasherNotyfExtension;
use Flasher\Symfony\Bridge\FlasherBundle;

class FlasherNotyfSymfonyBundle extends FlasherBundle
{
    protected function getFlasherContainerExtension()
    {
        return new FlasherNotyfExtension();
    }
}
