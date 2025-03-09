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
 * ResourceManager - Manages resources for notification responses.
 *
 * This class is responsible for populating Response objects with the resources
 * (scripts, styles, options) required by the notifications they contain. It also
 * handles rendering HTML templates for notifications that require it.
 *
 * Design patterns:
 * - Builder: Builds complete responses by adding resources incrementally
 * - Template Method: Defines the algorithm for populating responses with customizable steps
 *
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
     * Creates a new ResourceManager instance.
     *
     * @param TemplateEngineInterface $templateEngine Engine for rendering notification templates
     * @param AssetManagerInterface   $assetManager   Manager for resolving asset paths
     * @param string|null             $mainScript     Path to the main PHPFlasher script
     * @param ResourceType[]          $resources      Configuration for plugin-specific resources
     */
    public function __construct(
        private TemplateEngineInterface $templateEngine,
        private AssetManagerInterface $assetManager,
        private ?string $mainScript = null,
        private array $resources = [],
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * This implementation:
     * 1. Sets the main script path if available
     * 2. Identifies unique plugins used by the notifications
     * 3. Renders HTML templates for notifications that need them
     * 4. Adds resources (scripts, styles, options) for each plugin
     */
    public function populateResponse(Response $response): Response
    {
        if (null !== $this->mainScript) {
            $response->setMainScript($this->assetManager->getPath($this->mainScript));
        }

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

    /**
     * Adds an HTML stamp to a notification envelope.
     *
     * This method renders a template for the notification and attaches the
     * rendered HTML as a stamp on the envelope.
     *
     * @param string   $view     The template view name
     * @param Envelope $envelope The notification envelope
     */
    private function addHtmlStamp(string $view, Envelope $envelope): void
    {
        $compiled = $this->templateEngine->render($view, ['envelope' => $envelope]);

        $envelope->withStamp(new HtmlStamp($compiled));
    }

    /**
     * Adds resources for a plugin to a response.
     *
     * This method retrieves the resource configuration for a plugin and adds
     * its scripts, styles, and options to the response.
     *
     * @param Response $response The response to populate
     * @param string   $plugin   The plugin alias
     */
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
