<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Plugin\Plugin;

final class ToastrPlugin extends Plugin
{
    public function getAlias(): string
    {
        return 'toastr';
    }

    public function getFactory(): string
    {
        return Toastr::class;
    }

    public function getServiceAliases(): string
    {
        return ToastrInterface::class;
    }

    public function getScripts(): string
    {
        return '/vendor/flasher/flasher-toastr.min.js';
    }

    public function getStyles(): string
    {
        return '/vendor/flasher/flasher-toastr.min.css';
    }
}
