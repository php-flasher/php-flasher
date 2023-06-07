<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\HandlerStamp;

use function in_array;
use function strlen;

final class ResourceManager implements ResourceManagerInterface
{
    private readonly ConfigInterface $config;

    /**
     * @var array<string, string[]>
     */
    private array $scripts = [];

    /**
     * @var array<string, string[]>
     */
    private array $styles = [];

    /**
     * @var array<string, array<string, mixed>>
     */
    private array $options = [];

    public function __construct(ConfigInterface $config = null)
    {
        $this->config = $config ?: new Config();
    }

    public function populateResponse(Response $response): Response
    {
        /** @var string $rootScript */
        $rootScript = $this->config->get('root_script');
        $response->setRootScript($rootScript);

        $handlers = [];
        foreach ($response->getEnvelopes() as $envelope) {
            $handler = $this->resolveHandler($envelope);
            if (null === $handler) {
                continue;
            }

            if (in_array($handler, $handlers, true)) {
                continue;
            }

            $handlers[] = $handler;

            $response->addScripts($this->scripts[$handler] ?? []);
            $response->addStyles($this->styles[$handler] ?? []);
            $response->addOptions($handler, $this->options[$handler] ?? []);
        }

        return $response;
    }

    public function addScripts(string $handler, array $scripts): void
    {
        $this->scripts[$handler] = $scripts;
    }

    public function addStyles(string $handler, array $styles): void
    {
        $this->styles[$handler] = $styles;
    }

    public function addOptions(string $handler, array $options): void
    {
        $this->options[$handler] = $options;
    }

    private function resolveHandler(Envelope $envelope): ?string
    {
        $stamp = $envelope->get(HandlerStamp::class);
        if (! $stamp instanceof HandlerStamp) {
            return null;
        }

        $handler = $stamp->getHandler();
        if (! str_starts_with($handler, 'theme.')) {
            return $handler;
        }

        $theme = substr($handler, strlen('theme.'));

        /**
         * @var array{
         *     scripts?: string[],
         *     styles?: string[],
         *     options?: array<string, mixed>,
         * } $config
         */
        $config = $this->config->get('themes.'.$theme, []);

        $this->addScripts($handler, $config['scripts'] ?? []);
        $this->addStyles($handler, $config['styles'] ?? []);
        $this->addOptions($handler, $config['options'] ?? []);

        return 'theme.'.$theme;
    }
}
