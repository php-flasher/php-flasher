<?php

namespace Flasher\Symfony\Bridge\Legacy\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

abstract class FlasherExtension extends Extension
{
    public function getAlias()
    {
        return $this->getFlasherAlias();
    }

    /**
     * @return string
     */
    abstract protected function getFlasherAlias();
}
