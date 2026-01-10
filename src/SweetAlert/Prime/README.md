# PHPFlasher SweetAlert Adapter (Prime)

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)

SweetAlert2 adapter for PHPFlasher. Beautiful alert dialogs with modal and toast support.

## Requirements

- PHP >= 8.2
- PHPFlasher ^2.4.0

## Installation

```bash
composer require php-flasher/flasher-sweetalert
```

## Quick Start

```php
use Flasher\SweetAlert\Prime\SweetAlertFactory;

// Basic usage
SweetAlert::success('Operation completed successfully!');
SweetAlert::error('An error occurred.');
SweetAlert::info('Information message.');
SweetAlert::warning('Warning message.');

// With options
SweetAlert::success('Success message', [
    'timer' => 3000,
    'toast' => true,
    'position' => 'top-end',
]);

// Modal dialog
SweetAlert::success('Profile updated!')
    ->confirmButtonText('Great!')
    ->timer(5000);
```

## Features

- **Simple API**: `success()`, `error()`, `info()`, `warning()`, `flash()`
- **SweetAlert2 Options**: `timer`, `toast`, `position`, `showConfirmButton`, `showCancelButton`
- **Modal Support**: Full SweetAlert2 modal dialogs and toasts
- **Type Safety**: Full PHP type hints and PHPStan support
- **Helper Functions**: Global `sweetalert()` helper for quick access

## Available Methods

```php
// Success notification
SweetAlert::success($message, $title, $options);

// Error notification
SweetAlert::error($message, $title, $options);

// Info notification
SweetAlert::info($message, $title, $options);

// Warning notification
SweetAlert::warning($message, $title, $options);

// Custom notification type
SweetAlert::flash($type, $message, $title, $options);

// Set options
SweetAlert::success($message)
    ->timer(3000)
    ->toast(true)
    ->position('top-end');
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
