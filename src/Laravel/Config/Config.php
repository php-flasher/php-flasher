<?php

namespace Flasher\Laravel\Config;

use Flasher\Prime\Config\ConfigInterface;
use Illuminate\Config\Repository;

final class Config implements ConfigInterface
{
    private $config;

    private $separator;

    public function __construct(Repository $config, $separator = '.')
    {
        $this->config = $config;
        $this->separator = $separator;
    }

    public function get($key, $default = null)
    {
        return $this->getFrom('flasher', $key, $default);
    }

    public function getFrom($namespace, $key, $default = null)
    {
        return $this->config->get($namespace . $this->separator . $key, $default);
    }
}
