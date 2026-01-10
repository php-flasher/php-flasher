# PHPFlasher Noty Adapter (Prime)

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)

Noty adapter for PHPFlasher. Feature-rich notification library with queue support.

## Requirements

- PHP >= 8.2
- PHPFlasher ^2.4.0

## Installation

```bash
composer require php-flasher/flasher-noty
```

## Quick Start

```php
use Flasher\Noty\Prime\NotyFactory;

// Basic usage
Noty::success('Operation completed successfully!');
Noty::error('An error occurred.');
Noty::info('Information message.');
Noty::warning('Warning message.');

// With options
Noty::success('Success message', [
    'timeout' => 3000,
    'layout' => 'topCenter',
    'progressBar' => true,
]);

// Custom notification
Noty::flash('custom-type', 'Custom message');
```

## Features

- **Simple API**: `success()`, `error()`, `info()`, `warning()`, `flash()`
- **Noty Options**: `layout`, `theme`, `timeout`, `progressBar`, `closeWith`
- **Queue Support**: Named queue system for notification ordering
- **Type Safety**: Full PHP type hints and PHPStan support
- **Helper Functions**: Global `noty()` helper for quick access

## Available Methods

```php
// Success notification
Noty::success($message, $title, $options);

// Error notification
Noty::error($message, $title, $options);

// Info notification
Noty::info($message, $title, $options);

// Warning notification
Noty::warning($message, $title, $options);

// Custom notification type
Noty::flash($type, $message, $title, $options);

// Set options
Noty::success($message)
    ->layout('topCenter')
    ->timeout(3000)
    ->theme('mint');
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
