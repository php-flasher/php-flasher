<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Config\Config;
use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Response\Response;
use Flasher\Prime\Stamp\HandlerStamp;
use Flasher\Prime\Stamp\ViewStamp;
use Flasher\Prime\Template\TemplateEngineInterface;

final class ResourceManager implements ResourceManagerInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var TemplateEngineInterface|null
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
     * @var array<string, array<string, mixed>>
     */
    private $options = array();

    public function __construct(ConfigInterface $config = null, TemplateEngineInterface $templateEngine = null)
    {
        $this->config = $config ?: new Config();
        $this->templateEngine = $templateEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function buildResponse(Response $response)
    {
        /** @var string $rootScript */
        $rootScript = $this->config->get('root_script');
        $response->setRootScript($rootScript);

        $handlers = array();
        foreach ($response->getEnvelopes() as $envelope) {
            $handler = $this->resolveHandler($envelope);
            if (null === $handler || \in_array($handler, $handlers, true)) {
                continue;
            }
            $handlers[] = $handler;

            $this->populateResponse($response, $handler);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function addScripts($handler, array $scripts)
    {
        $this->scripts[$handler] = $scripts;
    }

    /**
     * {@inheritdoc}
     */
    public function addStyles($handler, array $styles)
    {
        $this->styles[$handler] = $styles;
    }

    /**
     * {@inheritdoc}
     */
    public function addOptions($handler, array $options)
    {
        $this->options[$handler] = $options;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string|null
     */
    private function resolveHandler(Envelope $envelope)
    {
        $handlerStamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');
        if (!$handlerStamp instanceof HandlerStamp) {
            return null;
        }

        $handler = $handlerStamp->getHandler();
        if ('flasher' !== $handler && 0 !== strpos($handler, 'theme.')) {
            return $handler;
        }

        $theme = $this->getTheme($handler);
        if (null === $theme) {
            return $handler;
        }

        if (!isset($this->options[$handler])) {
            /** @var array<string, mixed> $options */
            $options = $this->config->get('themes.'.$theme.'.options', array());
            $this->addOptions('theme.'.$theme, $options);
        }

        /** @var string|null $view */
        $view = $this->config->get('themes.'.$theme.'.view');
        if (null === $view || null === $this->templateEngine) {
            return 'theme.'.$theme;
        }

        $compiled = $this->templateEngine->render($view, array('envelope' => $envelope));
        $envelope->withStamp(new ViewStamp($compiled));

        return 'theme.'.$theme;
    }

    /**
     * @param string $handler
     *
     * @return string|null
     */
    private function getTheme($handler)
    {
        if ('flasher' === $handler) {
            return 'flasher';
        }

        if (0 === strpos($handler, 'theme.')) {
            return substr($handler, \strlen('theme.'));
        }

        return null;
    }

    /**
     * @param string $handler
     *
     * @return void
     */
    private function populateResponse(Response $response, $handler)
    {
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
}
