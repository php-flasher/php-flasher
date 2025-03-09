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

/**
 * ResponseManager - Manages notification response generation and presentation.
 *
 * This class orchestrates the process of retrieving notifications from storage,
 * populating them with resources (scripts, styles), and rendering them with the
 * appropriate presenter. It serves as the central coordinator for notification rendering.
 *
 * Design patterns:
 * - Mediator: Coordinates the interaction between storage, resources, events, and presenters
 * - Strategy: Uses different presentation strategies based on the requested format
 * - Factory: Creates presenters on demand
 */
final class ResponseManager implements ResponseManagerInterface
{
    /**
     * Registry of presenter instances or factories.
     *
     * @var callable[]|PresenterInterface[]
     */
    private array $presenters = [];

    /**
     * Creates a new ResponseManager instance.
     *
     * @param ResourceManagerInterface $resourceManager Manager for adding resources to responses
     * @param StorageManagerInterface  $storageManager  Manager for accessing stored notifications
     * @param EventDispatcherInterface $eventDispatcher Dispatcher for notification events
     */
    public function __construct(
        private readonly ResourceManagerInterface $resourceManager,
        private readonly StorageManagerInterface $storageManager,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
        $this->addPresenter('html', fn () => new HtmlPresenter());
        $this->addPresenter('json', fn () => new ArrayPresenter());
        $this->addPresenter('array', fn () => new ArrayPresenter());
    }

    /**
     * {@inheritdoc}
     *
     * This implementation follows a multi-step process:
     * 1. Filters notifications from storage based on criteria
     * 2. Removes rendered notifications from storage
     * 3. Dispatches a PresentationEvent to allow listeners to modify notifications
     * 4. Creates a Response object with notifications and context
     * 5. Uses the appropriate presenter to render the response
     * 6. Dispatches a ResponseEvent to allow final modifications
     */
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

    /**
     * Creates a presenter instance for the specified format.
     *
     * This method retrieves a presenter by alias from the registry and instantiates
     * it if it's a factory closure.
     *
     * @param string $alias The presenter alias
     *
     * @return PresenterInterface The presenter instance
     *
     * @throws PresenterNotFoundException If no presenter is registered with the given alias
     */
    private function createPresenter(string $alias): PresenterInterface
    {
        if (!isset($this->presenters[$alias])) {
            throw PresenterNotFoundException::create($alias, array_keys($this->presenters));
        }

        $presenter = $this->presenters[$alias];

        return \is_callable($presenter) ? $presenter() : $presenter;
    }

    /**
     * Creates a Response object with notifications and context.
     *
     * This method creates a basic Response object and then populates it with
     * resources (scripts, styles, options) using the ResourceManager.
     *
     * @param Envelope[]           $envelopes The notification envelopes
     * @param array<string, mixed> $context   Additional context for the presentation
     *
     * @return Response The populated response object
     */
    private function createResponse(array $envelopes, array $context): Response
    {
        $response = new Response($envelopes, $context);

        return $this->resourceManager->populateResponse($response);
    }

    /**
     * Uses a presenter to render a response.
     *
     * This method selects the appropriate presenter based on the requested format
     * and uses it to render the response.
     *
     * @param Response $response  The response to render
     * @param string   $presenter The presenter format to use
     *
     * @return mixed The rendered result
     */
    private function presentResponse(Response $response, string $presenter): mixed
    {
        $presenter = $this->createPresenter($presenter);

        return $presenter->render($response);
    }
}
