<?php

namespace Flasher\Laravel\Config;

use Flasher\Prime\Config\ConfigInterface;
use Illuminate\Config\Repository;

final class Config implements ConfigInterface
{
    /** @var Repository  */
    private $config;

    /** @var string  */
    private $separator;

    /**
     * @param string $separator
     */
    public function __construct(Repository $config, $separator = '.')
    {
        $this->config = $config;
        $this->separator = $separator;
    }

    public function get($key, $default = null)
    {
        return $this->getFrom('flasher', $key, $default);
    }

    /**
     * @param string $namespace
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getFrom($namespace, $key, $default = null)
    {
        return $this->config->get($namespace . $this->separator . $key, $default);
    }
}
