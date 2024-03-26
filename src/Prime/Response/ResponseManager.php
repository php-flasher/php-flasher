<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\EventDispatcher\Event\ResponseEvent;
use Flasher\Prime\EventDispatcher\EventDispatcherInterface;
use Flasher\Prime\Exception\PresenterNotFoundException;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Response\Presenter\ArrayPresenter;
use Flasher\Prime\Response\Presenter\HtmlPresenter;
use Flasher\Prime\Response\Presenter\PresenterInterface;
use Flasher\Prime\Response\Resource\ResourceManagerInterface;
use Flasher\Prime\Storage\StorageManagerInterface;

final class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var callable[]|PresenterInterface[]
     */
    private array $presenters = [];

    public function __construct(
        private readonly ResourceManagerInterface $resourceManager,
        private readonly StorageManagerInterface $storageManager,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
        $this->addPresenter('html', fn () => new HtmlPresenter());
        $this->addPresenter('json', fn () => new ArrayPresenter());
        $this->addPresenter('array', fn () => new ArrayPresenter());
    }

    public function render(string $presenter = 'html', array $criteria = [], array $context = []): mixed
    {
        $envelopes = $this->storageManager->filter($criteria);
        $this->storageManager->remove(...$envelopes);

        $event = new PresentationEvent($envelopes, $context);
        $this->eventDispatcher->dispatch($event);

        $response = $this->createResponse($event->getEnvelopes(), $context);
        $response = $this->presentResponse($response, $presenter);

        $event = new ResponseEvent($response, $presenter);
        $this->eventDispatcher->dispatch($event);

        return $event->getResponse();
    }

    public function addPresenter(string $alias, callable|PresenterInterface $presenter): void
    {
        $this->presenters[$alias] = $presenter;
    }

    private function createPresenter(string $alias): PresenterInterface
    {
        if (!isset($this->presenters[$alias])) {
            throw PresenterNotFoundException::create($alias, array_keys($this->presenters));
        }

        $presenter = $this->presenters[$alias];

        return \is_callable($presenter) ? $presenter() : $presenter;
    }

    /**
     * @param Envelope[]           $envelopes
     * @param array<string, mixed> $context
     */
    private function createResponse(array $envelopes, array $context): Response
    {
        $response = new Response($envelopes, $context);

        return $this->resourceManager->populateResponse($response);
    }

    private function presentResponse(Response $response, string $presenter): mixed
    {
        $presenter = $this->createPresenter($presenter);

        return $presenter->render($response);
    }
}
