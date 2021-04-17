<?php

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Symfony\DependencyInjection\FlasherNotyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlasherNotySymfonyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new FlasherNotyExtension();
    }
}
