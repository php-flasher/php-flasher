<?php

declare(strict_types=1);

namespace Flasher\Prime;

/**
 * Configuration for PHPFlasher.
 *
 * This class provides type-safe access to PHPFlasher's configuration structure.
 * It uses PHPStan annotations to define the complex nested configuration schema,
 * ensuring configuration consistency and enabling IDE autocompletion.
 *
 * Design pattern: Type-safe Configuration - Uses PHP's type system to validate
 * and document complex configuration structures.
 *
 * The configuration array structure contains:
 * - default: The default notification adapter to use
 * - main_script: Main JavaScript file path
 * - scripts: Additional JavaScript files to include
 * - styles: CSS stylesheets to include
 * - inject_assets: Whether to auto-inject assets in responses
 * - translate: Whether to translate notifications
 * - excluded_paths: Paths where notifications shouldn't be displayed
 * - options: Global notification options
 * - filter: Default filtering criteria
 * - flash_bag: Flash bag configuration for framework integration
 * - presets: Notification templates/presets with type, title, message and options
 * - plugins: Plugin-specific configuration with scripts, styles and options
 *
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
 *         options: array<string, mixed>
 *     }>,
 *     plugins?: array<string, array{
 *         scripts?: string[],
 *         styles?: string[],
 *         options?: array<string, mixed>
 *     }>
 * }
 */
final class Configuration
{
    /**
     * Validates and returns the configuration array.
     *
     * This method serves as a type-safe wrapper around configuration arrays,
     * ensuring that they match the expected schema defined in the PHPStan annotations.
     *
     * @phpstan-param ConfigType $config
     *
     * @phpstan-return ConfigType
     */
    public static function from(array $config): array
    {
        return $config;
    }
}
