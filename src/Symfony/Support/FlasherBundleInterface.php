<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;

interface FlasherBundleInterface
{
    public function createPlugin(): PluginInterface;
}
