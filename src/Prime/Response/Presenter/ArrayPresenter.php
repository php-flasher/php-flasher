<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

/**
 * ArrayPresenter - Presents notifications as a PHP array structure.
 *
 * This presenter converts a Response object into a PHP array structure that can
 * be used for further processing, serialization, or API responses. It's particularly
 * useful as a base for other presenters that need structured data rather than
 * rendered output.
 *
 * Design patterns:
 * - Presenter: Transforms domain objects (Notifications) into a presentation format
 * - Adapter: Converts internal representation to a format suitable for external use
 *
 * @phpstan-type ArrayPresenterType array{
 *      envelopes: array<array{
 *          title: string,
 *          message: string,
 *          type: string,
 *          options: array<string, mixed>,
 *          metadata: array<string, mixed>,
 *      }>,
 *      scripts: string[],
 *      styles: string[],
 *      options: array<string, array<string, mixed>>,
 *      context: array<string, mixed>,
 *  }
 */
final class ArrayPresenter implements PresenterInterface
{
    /**
     * Renders a response as a PHP array.
     *
     * This method simply calls toArray() on the response object to convert it
     * to a structured array representation.
     *
     * @param Response $response The response to render
     *
     * @return array The array representation of the response
     *
     * @phpstan-return ArrayPresenterType
     */
    public function render(Response $response): array
    {
        return $response->toArray();
    }
}
