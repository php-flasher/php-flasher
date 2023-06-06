<?php

namespace Flasher\Prime\Config;

/**
 * @phpstan-import-type ConfigType from ConfigInterface
 */
final class Config implements ConfigInterface
{
    /**
     * @phpstan-var array{}|ConfigType
     */
    private $config;

    /**
     * @phpstan-param array{}|ConfigType $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function get($key, $default = null)
    {
        $data = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (!isset($data[$segment])) { // @phpstan-ignore-line
                return $default;
            }

            $data = $data[$segment];
        }

        return $data;
    }
}
