<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

interface RequestExtensionInterface
{
    public function flash(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}
