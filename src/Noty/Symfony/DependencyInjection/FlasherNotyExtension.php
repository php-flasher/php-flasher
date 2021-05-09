<?php

namespace Flasher\Noty\Symfony\DependencyInjection;

use Flasher\Symfony\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

final class FlasherNotyExtension extends Extension
{
    protected function getConfigFileLocator()
    {
        return new FileLocator(__DIR__ . '/../Resources/config');
    }

    protected function getConfigClass()
    {
        return new Configuration();
    }
}
