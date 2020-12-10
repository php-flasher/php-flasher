<?php

namespace Flasher\Prime\Renderer\Response;

interface ResponseManagerInterface
{
    /**
     * @param string            $alias
     * @param ResponseInterface $response
     */
    public function addResponse($alias, ResponseInterface $response);

    /**
     * @param string $alias
     *
     * @return ResponseInterface
     */
    public function create($alias);
}
