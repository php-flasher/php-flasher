<?php

namespace Flasher\Prime\Renderer;

use Flasher\Prime\Config\ConfigInterface;
use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
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
     * @param StorageManagerInterface  $storageManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param ConfigInterface          $config
     */
    public function __construct(
        StorageManagerInterface $storageManager,
        EventDispatcherInterface $eventDispatcher,
        ConfigInterface $config
    ) {
        $this->storageManager = $storageManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->config = $config;
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function render(array $criteria = array())
    {
        $envelopes = $this->getEnvelopes($criteria);

        if (empty($envelopes)) {
            return array();
        }

        $response = array(
            'scripts'       => $this->getScripts($envelopes),
            'styles'        => $this->getStyles($envelopes),
            'options'       => $this->getOptions($envelopes),
            'notifications' => $this->getNotifications($envelopes),
        );

        $this->storageManager->remove($envelopes);

        return $response;
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

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    private function getStyles(array $envelopes)
    {
        return $this->getAssets('styles', $envelopes);
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    private function getScripts(array $envelopes)
    {
        return $this->getAssets('scripts', $envelopes);
    }

    /**
     * @param Envelope[] $envelopes
     *
     * @return string[]
     */
    private function getOptions(array $envelopes)
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
     * @return array[]
     */
    private function getNotifications(array $envelopes)
    {
        return array_map(function (Envelope $envelope) {
            return array(
                'handler' => $envelope->get('Flasher\Prime\Stamp\HandlerStamp')->getHandler(),
                'notification' => $envelope->toArray(),
            );
        }, $envelopes);
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
