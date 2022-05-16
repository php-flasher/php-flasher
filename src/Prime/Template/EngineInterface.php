<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Template;

interface EngineInterface
{
    /**
     * @param string               $name
     * @param array<string, mixed> $context
     *
     * @return string
     */
    public function render($name, array $context = array());
}
