<?php

namespace Flasher\Laravel\Container;

use Flasher\Prime\Container\ContainerInterface;

final class LaravelContainer implements ContainerInterface
{
    public function get($id)
    {
        return app()->make($id);
    }
}
