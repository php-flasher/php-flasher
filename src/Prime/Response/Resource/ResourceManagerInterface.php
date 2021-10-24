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
     *
     * @return void
     */
    public function addScripts($alias, array $scripts);

    /**
     * @param string   $alias
     * @param string[] $styles
     *
     * @return void
     */
    public function addStyles($alias, array $styles);

    /**
     * @param string $alias
     * @param mixed[] $options
     *
     * @return void
     */
    public function addOptions($alias, array $options);
}
