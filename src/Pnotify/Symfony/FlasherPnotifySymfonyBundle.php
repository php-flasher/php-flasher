<?php

namespace Flasher\Pnotify\Symfony;

use Flasher\Pnotify\Symfony\DependencyInjection\FlasherPnotifyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlasherPnotifySymfonyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new FlasherPnotifyExtension();
    }
}
