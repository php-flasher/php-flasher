<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\PluginStamp;
use function in_array;

final class ResourceManager implements ResourceManagerInterface
{
    private readonly ConfigInterface $config;

    public function __construct(ConfigInterface $config = null)
    {
        $this->config = $config ?: new Config();
    }

    public function populateResponse(Response $response): Response
    {
        /** @var string $rootScript */
        $rootScript = $this->config->get('root_script');
        $response->setRootScript($rootScript);

        $plugins = [];
        foreach ($response->getEnvelopes() as $envelope) {
            $plugin = $envelope->get(PluginStamp::class)?->getPlugin();
            if (null === $plugin || in_array($plugin, $plugins, true)) {
                continue;
            }

            $plugins[] = $plugin;

            /**
             * @var array{
             *     scripts?: string[],
             *     styles?: string[],
             *     options?: array<string, mixed>,
             * } $resource
             */
            $resource = $this->config->get("plugins.$plugin", []);

            $response->addScripts($resource['scripts'] ?? []);
            $response->addStyles($resource['styles'] ?? []);
            $response->addOptions($plugin, $resource['options'] ?? []);
        }

        return $response;
    }
}
