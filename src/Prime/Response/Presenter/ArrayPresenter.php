<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

final class ArrayPresenter implements PresenterInterface
{
    /**
     * @return array{
     *     envelopes: array<array{
     *         title: string,
     *         message: string,
     *         type: string,
     *         options: array<string, mixed>,
     *         metadata: array<string, mixed>,
     *     }>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, array<string, mixed>>,
     *     context: array<string, mixed>,
     * }
     */
    public function render(Response $response): array
    {
        return $response->toArray();
    }
}
