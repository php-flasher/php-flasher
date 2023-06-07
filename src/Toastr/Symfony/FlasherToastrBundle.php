<?php

declare(strict_types=1);

namespace Flasher\Toastr\Symfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Flasher\Symfony\Support\PluginExtension;
use Flasher\Toastr\Prime\ToastrPlugin;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

final class FlasherToastrBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new PluginExtension(new ToastrPlugin());
    }
}
