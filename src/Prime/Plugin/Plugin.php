<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

abstract class Plugin implements PluginInterface
{
    public function getName(): string
    {
        return 'flasher_'.$this->getAlias();
    }

    public function getServiceId(): string
    {
        return 'flasher.'.$this->getAlias();
    }

    public function getServiceAliases(): string|array
    {
        return [];
    }

    public function getScripts(): string|array
    {
        return [];
    }

    public function getStyles(): string|array
    {
        return [];
    }

    public function getOptions(): array
    {
        return [];
    }

    public function normalizeConfig(array $config): array
    {
        $config = [
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
            ...$config,
        ];

        $config['scripts'] = (array) $config['scripts'];
        $config['styles'] = (array) $config['styles'];

        return $config;
    }
}
