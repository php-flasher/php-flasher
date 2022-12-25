<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Container;

interface ContainerInterface
{
    /**
     * @param string $id
     *
     * @return mixed
     */
    public function get($id);
}
