<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\PluginStamp;

/**
 * @phpstan-type ResourceType array{
 *     scripts?: string[],
 *     styles?: string[],
 *     options?: array<string, mixed>,
 * }
 */
final class ResourceManager implements ResourceManagerInterface
{
    public function __construct(
        private readonly string $rootScript,
        /** @phpstan-var ResourceType[] */
        private readonly array $resources,
    ) {
    }

    public function populateResponse(Response $response): Response
    {
        $response->setMainScript($this->rootScript);

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

            $resource = $this->resources[$plugin] ?? [];

            $response->addScripts($resource['scripts'] ?? []);
            $response->addStyles($resource['styles'] ?? []);
            $response->addOptions($plugin, $resource['options'] ?? []);
        }

        return $response;
    }
}
