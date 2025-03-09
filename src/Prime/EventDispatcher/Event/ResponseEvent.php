<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

/**
 * ResponseEvent - Event dispatched when a response is being prepared.
 *
 * This event is dispatched during the response rendering process. It allows
 * listeners to modify the rendered response before it's returned to the client.
 * This is particularly useful for adapting the response format or adding
 * additional data.
 */
final class ResponseEvent
{
    /**
     * Creates a new ResponseEvent instance.
     *
     * @param mixed  $response  The response data that has been rendered
     * @param string $presenter The name of the presenter that rendered the response
     */
    public function __construct(
        private mixed $response,
        private readonly string $presenter,
    ) {
    }

    /**
     * Gets the current response data.
     *
     * @return mixed The response data
     */
    public function getResponse(): mixed
    {
        return $this->response;
    }

    /**
     * Sets the response data.
     *
     * This allows listeners to modify or replace the response content.
     *
     * @param mixed $response The new response data
     */
    public function setResponse(mixed $response): void
    {
        $this->response = $response;
    }

    /**
     * Gets the name of the presenter that rendered the response.
     *
     * @return string The presenter name (e.g., 'html', 'json')
     */
    public function getPresenter(): string
    {
        return $this->presenter;
    }
}
