<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Response\Response;

interface ResourceManagerInterface
{
    public function populateResponse(Response $response): Response;
}
