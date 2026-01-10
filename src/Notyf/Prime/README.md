# PHPFlasher Notyf Adapter (Prime)

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)

Notyf adapter for PHPFlasher. Lightweight and modern toast notifications.

## Requirements

- PHP >= 8.2
- PHPFlasher ^2.4.0

## Installation

```bash
composer require php-flasher/flasher-notyf
```

## Quick Start

```php
use Flasher\Notyf\Prime\NotyfFactory;

// Basic usage
Notyf::success('Operation completed successfully!');
Notyf::error('An error occurred.');
Notyf::info('Information message.');
Notyf::warning('Warning message.');

// With options
Notyf::success('Success message', [
    'duration' => 4000,
    'position' => 'top-right',
]);

// Custom notification
Notyf::flash('custom-type', 'Custom message');
```

## Features

- **Simple API**: `success()`, `error()`, `info()`, `warning()`, `flash()`
- **Notyf Options**: `duration`, `position`, `ripple`, `id`
- **Modern Design**: Clean, minimal design with smooth animations
- **Type Safety**: Full PHP type hints and PHPStan support
- **Helper Functions**: Global `notyf()` helper for quick access

## Available Methods

```php
// Success notification
Notyf::success($message, $title, $options);

// Error notification
Notyf::error($message, $title, $options);

// Info notification
Notyf::info($message, $title, $options);

// Warning notification
Notyf::warning($message, $title, $options);

// Custom notification type
Notyf::flash($type, $message, $title, $options);

// Set options
Notyf::success($message)
    ->duration(4000)
    ->position('top-right');
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
