<?php

namespace Flasher\Prime\Container;

interface ContainerInterface
{
    /**
     * @param string $id
     */
    public function get($id);
}
