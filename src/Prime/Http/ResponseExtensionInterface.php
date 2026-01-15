<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

interface ResponseExtensionInterface
{
    public function render(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}
