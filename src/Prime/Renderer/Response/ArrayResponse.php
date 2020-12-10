<?php

namespace Flasher\Prime\Renderer\Response;

final class ArrayResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    public function render(array $response, array $context = array())
    {
        return $response;
    }
}
