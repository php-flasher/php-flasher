<?php

declare(strict_types=1);

namespace Flasher\Prime\Config;

final class Config implements ConfigInterface
{
    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(private readonly array $config = [])
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $data = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (! is_array($data) || ! array_key_exists($segment, $data)) {
                return $default;
            }

            $data = $data[$segment];
        }

        return $data;
    }
}
