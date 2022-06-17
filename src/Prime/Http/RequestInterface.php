<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Http;

interface RequestInterface
{
    /**
     * @return bool
     */
    public function isXmlHttpRequest();

    /**
     * @return bool
     */
    public function isHtmlRequestFormat();

    /**
     * @return bool
     */
    public function hasSession();

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasType($type);

    /**
     * @param string $type
     *
     * @return string|string[]
     */
    public function getType($type);

    /**
     * @param string $type
     *
     * @return void
     */
    public function forgetType($type);
}
