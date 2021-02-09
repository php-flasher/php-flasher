<?php

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Response\Response;

final class ResourceManager implements ResourceManagerInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @var array<string, string[]>
     */
    private $scripts = array();

    /**
     * @var array<string, string[]>
     */
    private $styles = array();

    /**
     * @var array<string, array>
     */
    private $options = array();

    /**
     * @inheritDoc
     */
    public function filterResponse(Response $response)
    {
        $response->addScripts($this->config->get('root_scripts', array()));

        $handlers = array();

        foreach ($response->getEnvelopes() as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
            if (in_array($handler, $handlers)) {
                continue;
            }

            $handlers[] = $handler;

            if (isset($this->scripts[$handler])) {
                $response->addScripts($this->scripts[$handler]);
            }

            if (isset($this->scripts[$handler])) {
                $response->addStyles($this->styles[$handler]);
            }

            if (isset($this->scripts[$handler])) {
                $response->addOptions($handler, $this->options[$handler]);
            }
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function addScripts($alias, array $scripts)
    {
        $this->scripts[$alias] = $scripts;
    }

    /**
     * @inheritDoc
     */
    public function addStyles($alias, array $styles)
    {
        $this->styles[$alias] = $styles;
    }

    /**
     * @inheritDoc
     */
    public function addOptions($alias, array $options)
    {
        $this->options[$alias] = $options;
    }
}
