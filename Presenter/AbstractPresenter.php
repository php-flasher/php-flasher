<?php

namespace Flasher\Prime\Presenter;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\Filter\FilterManager;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererManager;
use Flasher\Prime\Storage\StorageInterface;

abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var Flasher\Prime\Storage\StorageInterface
     */
    protected $storage;

    /**
     * @var \Flasher\Prime\Filter\FilterManager
     */
    protected $filterManager;

    /**
     * @var \Flasher\Prime\Renderer\RendererManager
     */
    protected $rendererManager;

    /**
     * AbstractPresenter constructor.
     *
     * @param Flasher\Prime\Config\ConfigInterface   $config
     * @param \Flasher\Prime\Storage\StorageInterface $storage
     * @param \Flasher\Prime\Filter\FilterManager     $filterManager
     * @param \Flasher\Prime\Renderer\RendererManager $rendererManager
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
                $lifeStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');

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
            $rendererStamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');
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
            $rendererStamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');
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
            $rendererStamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');
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

    public function hasNotifications()
    {

    }
}
