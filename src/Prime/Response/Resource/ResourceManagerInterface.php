<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response\Resource;

use Flasher\Prime\Response\Response;

interface ResourceManagerInterface
{
    /**
     * @return Response
     */
    public function buildResponse(Response $response);

    /**
     * @param string   $handler
     * @param string[] $scripts
     *
     * @return void
     */
    public function addScripts($handler, array $scripts);

    /**
     * @param string   $handler
     * @param string[] $styles
     *
     * @return void
     */
    public function addStyles($handler, array $styles);

    /**
     * @param string               $handler
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function addOptions($handler, array $options);
}
