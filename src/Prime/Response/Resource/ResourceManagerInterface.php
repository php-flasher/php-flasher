<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Response\Response;

/**
 * ResourceManagerInterface - Contract for managing notification resources.
 *
 * This interface defines the essential operation for populating Response objects
 * with the resources (scripts, styles, options) required by the notifications
 * they contain.
 *
 * Design pattern: Builder - Defines an interface for incrementally building
 * complete responses with all required resources.
 */
interface ResourceManagerInterface
{
    /**
     * Populates a response with required resources.
     *
     * This method should analyze the notifications in the response and add
     * the scripts, styles, and options needed to render them properly.
     *
     * @param Response $response The response to populate
     *
     * @return Response The populated response
     */
    public function populateResponse(Response $response): Response;
}
