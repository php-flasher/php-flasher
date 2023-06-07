<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Symfony;

use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\Symfony\Support\PluginExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class FlasherSweetAlertBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension(new SweetAlertPlugin());
    }
}
