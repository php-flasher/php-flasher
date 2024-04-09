<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

final class ResponseEvent
{
    public function __construct(
        private mixed $response,
        private readonly string $presenter,
    ) {
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }

    public function setResponse(mixed $response): void
    {
        $this->response = $response;
    }

    public function getPresenter(): string
    {
        return $this->presenter;
    }
}
