<?php

namespace Flasher\Noty\Symfony;

use Flasher\Noty\Symfony\DependencyInjection\FlasherNotyExtension;
use Flasher\Symfony\Bridge\FlasherBundle;

class FlasherNotySymfonyBundle extends FlasherBundle
{
    protected function getFlasherContainerExtension()
    {
        return new FlasherNotyExtension();
    }
}
