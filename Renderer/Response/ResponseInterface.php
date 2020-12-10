<?php

namespace Flasher\Prime\Renderer\Response;

interface ResponseInterface
{
    /**
     * @param array $response
     * @param array $context
     *
     * @return mixed
     */
    public function render(array $response, array $context = array());
}
