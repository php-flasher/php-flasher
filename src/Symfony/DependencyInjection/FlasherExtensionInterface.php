<?php

namespace Flasher\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

interface FlasherExtensionInterface
{
    /**
     * @return ConfigurationInterface
     */
    public function getConfigurationClass();

    /**
     * @return string
     */
    public function getAlias();
}
