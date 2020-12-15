<?php

namespace Flasher\Prime\Renderer;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Renderer\Presenter\PresenterManager;
use Flasher\Prime\Renderer\Presenter\PresenterManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class Renderer implements RendererInterface
{
    /**
     * @var StorageManagerInterface
     */
    private $storageManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var PresenterManagerInterface
     */
    private $presenterManager;

    /**
     * @param StorageManagerInterface        $storageManager
     * @param EventDispatcherInterface       $eventDispatcher
     * @param ConfigInterface                $config
     * @param PresenterManagerInterface|null $presenterManager
     */
    public function __construct(
        StorageManagerInterface $storageManager,
        EventDispatcherInterface $eventDispatcher,
        ConfigInterface $config,
        PresenterManagerInterface $presenterManager = null
    ) {
        $this->storageManager = $storageManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->config = $config;
        $this->presenterManager = $presenterManager ?: new PresenterManager($config);
    }

    /**
     * @inheritDoc
     */
    public function render(array $criteria = array(), array $context = array())
    {
        $envelopes = $this->getEnvelopes($criteria);

        $this->storageManager->remove($envelopes);

        $event = new ResponseEvent($envelopes);
        $this->eventDispatcher->dispatch($event);

        $format = isset($context['format']) ? $context['format'] : 'array';

        return $this->presenterManager->create($format)->render($event->getEnvelopes(), $context);
    }

    /**
     * @param array $criteria
     *
     * @return Envelope[]
     */
    private function getEnvelopes(array $criteria)
    {
        $envelopes = $this->storageManager->all();

        $event = new FilterEvent($envelopes, $criteria);
        $this->eventDispatcher->dispatch($event);

        return $event->getEnvelopes();
    }
}
