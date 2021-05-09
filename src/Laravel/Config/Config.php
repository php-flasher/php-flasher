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
        return $this->config->get('flasher' . $this->separator . $key, $default);
    }
}
