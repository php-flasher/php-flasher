<?php

namespace Flasher\Pnotify\Symfony;

use Flasher\Pnotify\Symfony\DependencyInjection\FlasherPnotifyExtension;
use Flasher\Symfony\Bridge\FlasherBundle;

class FlasherPnotifySymfonyBundle extends FlasherBundle
{
    protected function getFlasherContainerExtension()
    {
        return new FlasherPnotifyExtension();
    }
}
