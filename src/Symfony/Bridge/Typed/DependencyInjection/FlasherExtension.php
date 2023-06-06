<?php

namespace Flasher\Symfony\Bridge\Typed\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

abstract class FlasherExtension extends Extension
{
    public function getAlias(): string
    {
        return $this->getFlasherAlias();
    }

    /**
     * @return string
     */
    abstract protected function getFlasherAlias();
}
