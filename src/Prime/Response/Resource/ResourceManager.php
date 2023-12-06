<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\PluginStamp;

final class ResourceManager implements ResourceManagerInterface
{
    public function __construct(private readonly ConfigInterface $config)
    {
    }

    public function populateResponse(Response $response): Response
    {
        /** @var string $rootScript */
        $rootScript = $this->config->get('root_script');
        $response->setMainScript($rootScript);

        $plugins = [];
        foreach ($response->getEnvelopes() as $envelope) {
            $plugin = $envelope->get(PluginStamp::class)?->getPlugin();
            if (null === $plugin) {
                continue;
            }

            if (\in_array($plugin, $plugins, true)) {
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
            $resource = $this->config->get(sprintf('plugins.%s', $plugin), []);

            $response->addScripts($resource['scripts'] ?? []);
            $response->addStyles($resource['styles'] ?? []);
            $response->addOptions($plugin, $resource['options'] ?? []);
        }

        return $response;
    }
}
