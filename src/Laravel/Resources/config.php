<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

return array(
    /*
    |--------------------------------------------------------------------------
    | Default PHPFlasher driver
    |--------------------------------------------------------------------------
    | This option controls the default driver that will be used by PHPFlasher.
    |
    | Supported drivers: "flasher", "toastr", "noty", "sweetalert", "pnotify"
    |
    | Only "flasher" is supported by default, but you can install other options using composer.
    |
    | "toastr"     : composer require php-flasher/flasher-toastr-laravel
    | "noty"       : composer require php-flasher/flasher-noty-laravel
    | "notyf"      : composer require php-flasher/flasher-notyf-laravel
    | "sweetalert" : composer require php-flasher/flasher-sweetalert-laravel
    | "pnotify"    : composer require php-flasher/flasher-pnotify-laravel
    */
    'default' => 'flasher',

    /*
    |--------------------------------------------------------------------------
    | Main PHPFlasher javascript file
    |--------------------------------------------------------------------------
    | This is the main javascript file that will be included in the page ony
    | when a notification is ready to be displayed, by defaut PHPFlasher
    | use a CDN with the latest version of the library. but you
    | could download it locally or install it with npm.
    */
    'root_script' => array(
        'cdn' => 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js',
        'local' => '/vendor/flasher/flasher.min.js',
    ),

    /*
    |--------------------------------------------------------------------------
    | Whether to use CDN for PHPFlasher assets or not
    |--------------------------------------------------------------------------
    | By default PHPFlasher use CDN for all assets, to use local version of
    | the assets set use_cdn to false.
    |
    | Don't forget to publish your assets with:
    |     php artisan vendor:publish --force --tag=flasher-assets
    */
    'use_cdn' => true,

    /*
    |--------------------------------------------------------------------------
    | Translate PHPFlasher messages
    |--------------------------------------------------------------------------
    | By default PHPFlasher messages are passed to Laravel translator service
    | to disable this behavior, set this option to `false`.
    */
    'auto_translate' => true,

    /*
    |--------------------------------------------------------------------------
    | Inject PHPFlasher in Response
    |--------------------------------------------------------------------------
    | PHPFlasher scripts are added automatically before </body>, by listening
    | to the Response after the App is done.
    */
    'auto_render' => true,

    'flash_bag' => array(
        /*
        |-----------------------------------------------------------------------
        | Enable flash bag
        |-----------------------------------------------------------------------
        | This option allows you to automatically convert Laravel's flash
        | messages to PHPFlasher notifications. This is useful when
        | you want to migrate from a Legacy system or another
        | library similar to PHPFlasher.
        */
        'enabled' => true,

        /*
        |-----------------------------------------------------------------------
        | Flash bag type mapping
        |-----------------------------------------------------------------------
        | This option allows you to map or convert session keys to PHPFlasher
        | notification types. on the right side are the PHPFlasher types
        | On the left side are the Laravel session keys that you
        | want to convert to PHPFlasher types.
        */
        'mapping' => array(
            'success' => array('success'),
            'error' => array('error', 'danger'),
            'warning' => array('warning', 'alarm'),
            'info' => array('info', 'notice', 'alert'),
        ),
    ),

    /*
    |-----------------------------------------------------------------------
    | Global Filter Criteria
    |-----------------------------------------------------------------------
    | This option allows you to filter the notifications that are displayed
    | by default all notifications are displayed, but you can filter
    | them, for example to only display errors.
    */
    'filter_criteria' => array(
        // 'limit' => 5, // Limit the number of notifications to display
    ),
);
