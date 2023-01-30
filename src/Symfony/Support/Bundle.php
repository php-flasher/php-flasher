<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Bridge\FlasherBundle;

abstract class Bundle extends FlasherBundle
{
    /**
     * @return PluginInterface
     */
    abstract public function createPlugin();

    public function getConfigurationFile()
    {
        return rtrim($this->getResourcesDir(), '/').'/config/config.yaml';
    }

    protected function getFlasherContainerExtension()
    {
        return new Extension($this->createPlugin());
    }

    /**
     * @return string
     */
    protected function getResourcesDir()
    {
        $r = new \ReflectionClass($this);

        return pathinfo($r->getFileName() ?: '', PATHINFO_DIRNAME).'/Resources/';
    }
}
