<?php

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\TemplateStamp;
use Flasher\Prime\Template\EngineInterface;

final class ResourceManager implements ResourceManagerInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var EngineInterface
     */
    private $templateEngine;

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

    public function __construct(ConfigInterface $config, EngineInterface $templateEngine)
    {
        $this->config = $config;
        $this->templateEngine = $templateEngine;
    }

    public function filterResponse(Response $response)
    {
        $response->addScripts($this->config->get('root_scripts', array()));

        $handlers = array();

        foreach ($response->getEnvelopes() as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();

            if ('template' === $handler) {
                $handler = $this->handleTemplateStamp($envelope);
            }

            if (in_array($handler, $handlers, true)) {
                continue;
            }

            $handlers[] = $handler;

            if (isset($this->scripts[$handler])) {
                $response->addScripts($this->scripts[$handler]);
            }

            if (isset($this->styles[$handler])) {
                $response->addStyles($this->styles[$handler]);
            }

            if (isset($this->options[$handler])) {
                $response->addOptions($handler, $this->options[$handler]);
            }
        }

        return $response;
    }

    public function addScripts($alias, array $scripts)
    {
        $this->scripts[$alias] = $scripts;
    }

    public function addStyles($alias, array $styles)
    {
        $this->styles[$alias] = $styles;
    }

    public function addOptions($alias, array $options)
    {
        $this->options[$alias] = $options;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    private function handleTemplateStamp(Envelope $envelope)
    {
        $view = $this->config->get('template_factory.default');
        $template = $this->config->get('template_factory.templates.' . $view . '.view');

        $compiled = $this->templateEngine->render($template, array(
            'envelope' => $envelope,
        ));

        $envelope->withStamp(new TemplateStamp($compiled));

        return 'template_' . $view;
    }
}
