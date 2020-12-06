<?php

namespace Flasher\Prime\Presenter;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\PostFilterEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Filter\FilterManagerInterface;
use Flasher\Prime\Renderer\HasOptionsInterface;
use Flasher\Prime\Renderer\HasScriptsInterface;
use Flasher\Prime\Renderer\HasStylesInterface;
use Flasher\Prime\Renderer\RendererManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var StorageManagerInterface
     */
    protected $storageManager;

    /**
     * @var FilterManagerInterface
     */
    protected $filterManager;

    /**
     * @var RendererManagerInterface
     */
    protected $rendererManager;

    /**
     * AbstractPresenter constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ConfigInterface          $config
     * @param StorageManagerInterface  $storageManager
     * @param FilterManagerInterface   $filterManager
     * @param RendererManagerInterface $rendererManager
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ConfigInterface $config,
        StorageManagerInterface $storageManager,
        FilterManagerInterface $filterManager,
        RendererManagerInterface $rendererManager
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->config          = $config;
        $this->storageManager  = $storageManager;
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

    /**
     * @param string $filterName
     * @param array  $criteria
     *
     * @return Envelope[]
     */
    protected function getEnvelopes($filterName, $criteria = array())
    {
        $filter = $this->filterManager->make($filterName);

        $envelopes = $this->storageManager->all();

        $event = new PostFilterEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $envelopes = $filter->filter($event->getEnvelopes(), $criteria);

        $event = new PostFilterEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        return $event->getEnvelopes();
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
            $handlerStamp = $envelope->get('Flasher\Prime\Stamp\HandlerStamp');
            if (in_array($handlerStamp->getHandler(), $renderers)) {
                continue;
            }

            $renderer = $this->rendererManager->make($handlerStamp->getHandler());
            if (!$renderer instanceof HasScriptsInterface) {
                continue;
            }

            $files       = array_merge($files, $renderer->getScripts());
            $renderers[] = $handlerStamp->getHandler();
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
}
