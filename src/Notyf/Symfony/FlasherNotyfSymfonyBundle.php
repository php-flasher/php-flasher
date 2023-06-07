<?php

declare(strict_types=1);

namespace Flasher\Notyf\Symfony;

use Flasher\Notyf\Prime\NotyfPlugin;
use Flasher\Symfony\Support\Bundle;

final class FlasherNotyfSymfonyBundle extends Bundle // Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function createPlugin(): NotyfPlugin
    {
        return new NotyfPlugin();
    }
}
