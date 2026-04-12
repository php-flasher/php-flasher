<?php

declare(strict_types=1);

use Flasher\Prime\Configuration;

/*
 * Default PHPFlasher configuration for Laravel.
 *
 * This configuration file defines the default settings for PHPFlasher when
 * used within a Laravel application. It uses the Configuration class from
 * the core PHPFlasher library to establish type-safe configuration.
 *
 * @return array<string, mixed> PHPFlasher configuration
 */
return Configuration::from([
    // Default notification adapter
    'default' => 'flasher',

    // Main script path
    'main_script' => '/vendor/flasher/flasher.min.js',

    // Prefix prepended to every flasher asset URL. Useful when the app is
    // served from a subdirectory (e.g. '/app') or a separate asset host
    // (e.g. 'https://cdn.example.com'). Leave empty when mounted at the root.
    'public_path' => '',

    // Stylesheet files
    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    // Global notification options
    // 'options' => [
    //     'timeout' => 5000,
    //     'position' => 'top-right',
    // ],

    // Auto-inject assets into responses
    'inject_assets' => true,

    // Enable automatic message translation
    'translate' => true,

    // URL patterns to exclude from asset injection and flash bag conversion
    'excluded_paths' => [],

    // Map Laravel session flash keys to notification types
    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    // Filter criteria for notifications
    // 'filter' => [
    //     'limit' => 5,
    // ],

    // Predefined notification configurations
    // 'presets' => [
    //     'entity_saved' => [
    //         'type' => 'success',
    //         'title' => 'Entity saved',
    //         'message' => 'Entity saved successfully',
    //     ],
    // ],
]);
