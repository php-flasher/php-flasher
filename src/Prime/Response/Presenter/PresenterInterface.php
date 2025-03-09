<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Presenter;

use Flasher\Prime\Response\Response;

/**
 * PresenterInterface - Contract for notification presenters.
 *
 * This interface defines the essential operation for transforming a Response
 * object into a specific presentation format. Different implementations can
 * render notifications as HTML, JSON, arrays, or other formats.
 *
 * Design pattern: Strategy - Defines a family of algorithms for rendering
 * notifications in different formats, making them interchangeable.
 */
interface PresenterInterface
{
    /**
     * Renders a response in a specific format.
     *
     * This method transforms the Response object into a presentation format
     * suitable for the specific presenter implementation. The return type
     * is mixed to accommodate different presentation formats (string, array, etc.).
     *
     * @param Response $response The response to render
     *
     * @return mixed The rendered result in the presenter's format
     */
    public function render(Response $response): mixed;
}
