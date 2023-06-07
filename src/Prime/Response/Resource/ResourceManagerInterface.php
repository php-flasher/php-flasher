<?php

declare(strict_types=1);

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Response\Response;

interface ResourceManagerInterface
{
    public function populateResponse(Response $response): Response;

    /**
     * @param  string[]  $scripts
     */
    public function addScripts(string $handler, array $scripts): void;

    /**
     * @param  string[]  $styles
     */
    public function addStyles(string $handler, array $styles): void;

    /**
     * @param  array<string, mixed>  $options
     */
    public function addOptions(string $handler, array $options): void;
}
