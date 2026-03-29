# PHPFlasher SweetAlert Adapter (Prime)

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)

SweetAlert2 adapter for PHPFlasher. Beautiful alert dialogs with modal and toast support.

## Requirements

- PHP >= 8.2
- PHPFlasher ^2.5.1

## Installation

```bash
composer require php-flasher/flasher-sweetalert
```

## Quick Start

```php
// Basic usage
sweetalert('Operation completed successfully!', 'success');
sweetalert('An error occurred.', 'error');
sweetalert('Information message.', 'info');
sweetalert('Warning message.', 'warning');

// With options
sweetalert('Success message', 'success', [
    'timer' => 3000,
    'toast' => true,
    'position' => 'top-end',
]);

// Modal dialog with options
sweetalert('Profile updated!', 'success', [
    'confirmButtonText' => 'Great!',
    'timer' => 5000,
]);
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
sweetalert($message, 'success', $options, $title);

// Error notification
sweetalert($message, 'error', $options, $title);

// Info notification
sweetalert($message, 'info', $options, $title);

// Warning notification
sweetalert($message, 'warning', $options, $title);

// Custom notification type
sweetalert($message, $type, $options, $title);

// With options
sweetalert($message, 'success', [
    'timer' => 3000,
    'toast' => true,
    'position' => 'top-end',
], $title);
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
