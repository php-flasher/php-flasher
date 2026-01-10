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
// Basic usage
noty('Operation completed successfully!', 'success');
noty('An error occurred.', 'error');
noty('Information message.', 'info');
noty('Warning message.', 'warning');

// With options
noty('Success message', 'success', [
    'timeout' => 3000,
    'layout' => 'topCenter',
    'progressBar' => true,
]);

// Custom notification
noty('Custom message', 'custom-type');
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
noty($message, 'success', $options, $title);

// Error notification
noty($message, 'error', $options, $title);

// Info notification
noty($message, 'info', $options, $title);

// Warning notification
noty($message, 'warning', $options, $title);

// Custom notification type
noty($message, $type, $options, $title);

// With options
noty($message, 'success', [
    'layout' => 'topCenter',
    'timeout' => 3000,
    'theme' => 'mint',
], $title);
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
