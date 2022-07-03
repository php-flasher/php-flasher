<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventDispatcher;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Resource\ResourceManager;
use Flasher\Prime\Response\Resource\ResourceManagerInterface;
use Flasher\Prime\Storage\StorageManager;
use Flasher\Prime\Storage\StorageManagerInterface;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var array<string, callable|PresenterInterface>
     */
    private $presenters;

    /**
     * @var ResourceManagerInterface
     */
    private $resourceManager;

    /**
     * @var StorageManagerInterface
     */
    private $storageManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(ResourceManagerInterface $resourceManager = null, StorageManagerInterface $storageManager = null, EventDispatcherInterface $eventDispatcher = null)
    {
        $this->resourceManager = $resourceManager ?: new ResourceManager();
        $this->storageManager = $storageManager ?: new StorageManager();
        $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();

        $this->addPresenter('html', new HtmlPresenter());
        $this->addPresenter('json', new ArrayPresenter());
        $this->addPresenter('array', new ArrayPresenter());
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $criteria = array(), $presenter = 'html', array $context = array())
    {
        $envelopes = $this->storageManager->filter($criteria);

        $this->storageManager->remove($envelopes);

        $event = new PresentationEvent($envelopes, $context);
        $this->eventDispatcher->dispatch($event);

        $response = $this->createResponse($event->getEnvelopes(), $context);
        $response = $this->createPresenter($presenter)->render($response);

        $event = new ResponseEvent($response, $presenter);
        $this->eventDispatcher->dispatch($event);

        return $event->getResponse();
    }

    /**
     * {@inheritdoc}
     */
    public function addPresenter($alias, $presenter)
    {
        $this->presenters[$alias] = $presenter;
    }

    /**
     * @param string $alias
     *
     * @return PresenterInterface
     */
    private function createPresenter($alias)
    {
        if (!isset($this->presenters[$alias])) {
            throw new \InvalidArgumentException(sprintf('Presenter [%s] not supported.', $alias));
        }

        $presenter = $this->presenters[$alias];

        return \is_callable($presenter) ? $presenter() : $presenter;
    }

    /**
     * @param Envelope[] $envelopes
     * @param mixed[]    $context
     *
     * @return Response
     */
    private function createResponse($envelopes, $context)
    {
        $response = new Response($envelopes, $context);

        return $this->resourceManager->buildResponse($response);
    }
}
