<?php

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Response\Response;

interface ResourceManagerInterface
{
    /**
     * @return Response
     */
    public function filterResponse(Response $response);

    /**
     * @param string   $alias
     * @param string[] $scripts
     */
    public function addScripts($alias, array $scripts);

    /**
     * @param string   $alias
     * @param string[] $styles
     */
    public function addStyles($alias, array $styles);

    /**
     * @param string $alias
     */
    public function addOptions($alias, array $options);
}
