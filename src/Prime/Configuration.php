<?php

declare(strict_types=1);

namespace Flasher\Prime;

/**
 * @phpstan-type ConfigType array{
 *     default: string,
 *     main_script?: string,
 *     scripts?: string[],
 *     styles?: string[],
 *     inject_assets?: bool,
 *     translate?: bool,
 *     excluded_paths?: list<non-empty-string>,
 *     options?: array<string, mixed>,
 *     filter?: array<string, mixed>,
 *     flash_bag?: false|array<string, string[]>,
 *     presets?: array<string, array{
 *         type: string,
 *         title: string,
 *         message: string,
 *         options: array<string, mixed>,
 *     }>,
 *     plugins?: array<string, array{
 *         scripts?: string[],
 *         styles?: string[],
 *         options?: array<string, mixed>,
 *     }>,
 * }
 */
final class Configuration
{
    /**
     * @param array{
     *      default: string,
     *      main_script?: string,
     *      scripts?: string[],
     *      styles?: string[],
     *      inject_assets?: bool,
     *      translate?: bool,
     *      excluded_paths?: list<non-empty-string>,
     *      options?: array<string, mixed>,
     *      filter?: array<string, mixed>,
     *      flash_bag?: false|array<string, string[]>,
     *      presets?: array<string, array{
     *          type: string,
     *          title: string,
     *          message: string,
     *          options: array<string, mixed>,
     *      }>,
     *      plugins?: array<string, array{
     *          scripts?: string[],
     *          styles?: string[],
     *          options?: array<string, mixed>,
     *      }>,
     *  } $config
     *
     * @phpstan-param ConfigType $config
     *
     * @return ConfigType
     */
    public static function from(array $config): array
    {
        return $config;
    }
}
