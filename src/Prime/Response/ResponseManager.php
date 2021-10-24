<?php

namespace Flasher\Prime\Response;

use Flasher\Prime\Envelope;
use Flasher\Prime\EventDispatcher\Event\FilterEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Resource\ResourceManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var PresenterInterface[]
     */
    private $presenters;

    /**
     * @var StorageManagerInterface
     */
    private $storageManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ResourceManagerInterface
     */
    private $resourceManager;

    public function __construct(
        StorageManagerInterface $storageManager,
        EventDispatcherInterface $eventDispatcher,
        ResourceManagerInterface $resourceManager
    ) {
        $this->storageManager = $storageManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->resourceManager = $resourceManager;
    }

    public function render(array $criteria = array(), $presenter = 'html', array $context = array())
    {
        $envelopes = $this->getEnvelopes($criteria);

        $this->storageManager->remove($envelopes);

        $response = $this->filterResponse($envelopes, $context);

        $presenter = $this->createPresenter($presenter);

        return $presenter->render($response);
    }

    /**
     * @param string $alias
     *
     * @return PresenterInterface
     */
    public function createPresenter($alias)
    {
        if (!isset($this->presenters[$alias])) {
            throw new \InvalidArgumentException(sprintf('[%s] presenter not supported.', $alias));
        }

        return $this->presenters[$alias];
    }

    /**
     * @param string $alias
     *
     * @return void
     */
    public function addPresenter($alias, PresenterInterface $presenter)
    {
        $this->presenters[$alias] = $presenter;
    }

    /**
     * @param Envelope[] $envelopes
     * @param mixed[] $context
     *
     * @return Response
     */
    private function filterResponse($envelopes, $context)
    {
        $response = new Response($envelopes, $context);

        return $this->resourceManager->filterResponse($response);
    }

    /**
     * @param mixed[] $criteria
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
