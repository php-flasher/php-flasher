<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Translation;

interface ResourceInterface
{
    /**
     * @return string
     */
    public function getResourceType();

    /**
     * @return string
     */
    public function getResourceName();
}
