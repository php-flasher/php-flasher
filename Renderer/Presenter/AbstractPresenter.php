<?php

namespace Flasher\Prime\Renderer\Presenter;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;

abstract class AbstractPresenter implements PresenterInterface
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
     * @param Envelope[] $envelopes
     *
     * @return array[]
     */
    protected function getEnvelopes(array $envelopes)
    {
        return array_map(function (Envelope $envelope) {
            return $envelope->toArray();
        }, $envelopes);
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getStyles(array $envelopes)
    {
        return $this->getAssets('styles', $envelopes);
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getScripts(array $envelopes)
    {
        return $this->getAssets('scripts', $envelopes);
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getOptions(array $envelopes)
    {
        $options = array();
        $handlers = array();

        foreach ($envelopes as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
            if (in_array($handler, $handlers)) {
                continue;
            }

            $handlers[] = $handler;
            $options[$handler] = $this->config->get(sprintf('adapters.%s.options', $handler), array());
        }

        return array_filter($options);
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return array
     */
    protected function toArray(array $envelopes = array())
    {
        return array(
            'scripts'   => $this->getScripts($envelopes),
            'styles'    => $this->getStyles($envelopes),
            'options'   => $this->getOptions($envelopes),
            'envelopes' => $this->getEnvelopes($envelopes),
        );
    }

    /**
     * @param string     $keyword
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    private function getAssets($keyword, $envelopes)
    {
        $files = $this->config->get($keyword, array());
        $handlers = array();

        foreach ($envelopes as $envelope) {
            $handler = $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler();
            if (in_array($handler, $handlers)) {
                continue;
            }

            $handlers[] = $handler;
            $files = array_merge($files, $this->config->get(sprintf('adapters.%s.%s', $handler, $keyword), array()));
        }

        return array_values(array_filter(array_unique($files)));
    }
}
