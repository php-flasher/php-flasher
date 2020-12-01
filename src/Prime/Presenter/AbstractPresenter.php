<?php

namespace Flasher\Prime\TestsPresenter;

use Notify\Config\ConfigInterface;
use Notify\Envelope;
use Flasher\Prime\TestsFilter\FilterManager;
use Flasher\Prime\TestsRenderer\HasOptionsInterface;
use Flasher\Prime\TestsRenderer\HasScriptsInterface;
use Flasher\Prime\TestsRenderer\HasStylesInterface;
use Flasher\Prime\TestsRenderer\RendererManager;
use Flasher\Prime\TestsStorage\StorageInterface;

abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * @var \Notify\Config\ConfigInterface
     */
    protected $config;

    /**
     * @var \Flasher\Prime\TestsStorage\StorageInterface
     */
    protected $storage;

    /**
     * @var \Flasher\Prime\TestsFilter\FilterManager
     */
    protected $filterManager;

    /**
     * @var \Flasher\Prime\TestsRenderer\RendererManager
     */
    protected $rendererManager;

    /**
     * AbstractPresenter constructor.
     *
     * @param \Notify\Config\ConfigInterface   $config
     * @param \Flasher\Prime\TestsStorage\StorageInterface $storage
     * @param \Flasher\Prime\TestsFilter\FilterManager     $filterManager
     * @param \Flasher\Prime\TestsRenderer\RendererManager $rendererManager
     */
    public function __construct(
        ConfigInterface $config,
        StorageInterface $storage,
        FilterManager $filterManager,
        RendererManager $rendererManager
    ) {
        $this->config          = $config;
        $this->storage         = $storage;
        $this->filterManager   = $filterManager;
        $this->rendererManager = $rendererManager;
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return get_class($this) === $name;
    }

    protected function getEnvelopes($filterName, $criteria = array())
    {
        $filter    = $this->filterManager->make($filterName);
        $envelopes = $filter->filter($this->storage->get(), $criteria);

        return array_filter(
            $envelopes,
            static function (Envelope $envelope) {
                $lifeStamp = $envelope->get('Flasher\Prime\TestsStamp\ReplayStamp');

                return $lifeStamp->getLife() > 0;
            }
        );
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getStyles($envelopes)
    {
        $files     = $this->config->get('styles', array());
        $renderers = array();

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Flasher\Prime\TestsStamp\HandlerStamp');
            if (in_array($rendererStamp->getHandler(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($rendererStamp->getHandler());
            if (!$renderer instanceof HasStylesInterface) {
                continue;
            }

            $files       = array_merge($files, $renderer->getStyles());
            $renderers[] = $rendererStamp->getHandler();
        }

        return array_values(array_filter(array_unique($files)));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getScripts($envelopes)
    {
        $files     = $this->config->get('scripts', array());
        $renderers = array();

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Flasher\Prime\TestsStamp\HandlerStamp');
            if (in_array($rendererStamp->getHandler(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($rendererStamp->getHandler());
            if (!$renderer instanceof HasScriptsInterface) {
                continue;
            }

            $files       = array_merge($files, $renderer->getScripts());
            $renderers[] = $rendererStamp->getHandler();
        }

        return array_values(array_filter(array_unique($files)));
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    protected function getOptions($envelopes)
    {
        $options   = array();
        $renderers = array();

        foreach ($envelopes as $envelope) {
            $rendererStamp = $envelope->get('Flasher\Prime\TestsStamp\HandlerStamp');
            if (in_array($rendererStamp->getHandler(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($rendererStamp->getHandler());
            if (!$renderer instanceof HasOptionsInterface) {
                continue;
            }

            $options[]   = $renderer->renderOptions();
            $renderers[] = $rendererStamp->getHandler();
        }

        return array_values(array_filter(array_unique($options)));
    }
}
