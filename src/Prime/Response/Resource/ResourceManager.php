<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Asset\AssetManagerInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\HtmlStamp;
use Flasher\Prime\Stamp\PluginStamp;
use Flasher\Prime\Template\TemplateEngineInterface;

/**
 * @phpstan-type ResourceType array{
 *     scripts?: string[],
 *     styles?: string[],
 *     options?: array<string, mixed>,
 *     view?: string,
 * }
 */
final readonly class ResourceManager implements ResourceManagerInterface
{
    /**
     * @phpstan-param ResourceType[] $resources
     */
    public function __construct(
        private TemplateEngineInterface $templateEngine,
        private AssetManagerInterface $assetManager,
        private string $mainScript,
        private array $resources,
    ) {
    }

    public function populateResponse(Response $response): Response
    {
        $response->setMainScript($this->assetManager->getPath($this->mainScript));

        $plugins = [];
        foreach ($response->getEnvelopes() as $envelope) {
            $plugin = $envelope->get(PluginStamp::class)?->getPlugin();
            if (null === $plugin) {
                continue;
            }

            $resource = $this->resources[$plugin] ?? [];
            if (isset($resource['view'])) {
                $this->addHtmlStamp($resource['view'], $envelope);
            }

            if (\in_array($plugin, $plugins, true)) {
                continue;
            }

            $plugins[] = $plugin;
            $this->addResources($response, $plugin);
        }

        return $response;
    }

    private function addHtmlStamp(string $view, Envelope $envelope): void
    {
        $compiled = $this->templateEngine->render($view, ['envelope' => $envelope]);

        $envelope->withStamp(new HtmlStamp($compiled));
    }

    private function addResources(Response $response, string $plugin): void
    {
        $resource = $this->resources[$plugin] ?? [];
        if ([] === $resource && str_starts_with($plugin, 'theme.')) {
            $resource = $this->resources['flasher'] ?? [];
        }

        $response->addScripts($this->assetManager->getPaths($resource['scripts'] ?? []));
        $response->addStyles($this->assetManager->getPaths($resource['styles'] ?? []));
        $response->addOptions($plugin, $resource['options'] ?? []);
    }
}
