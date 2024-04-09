<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Symfony;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\SweetAlert\Prime\SweetAlertPlugin;
use Flasher\Symfony\Support\PluginBundle;

final class FlasherSweetAlertBundle extends PluginBundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin(): PluginInterface
    {
        return new SweetAlertPlugin();
    }
}
