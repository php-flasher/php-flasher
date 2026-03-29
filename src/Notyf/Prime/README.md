# PHPFlasher Notyf Adapter (Prime)

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)

Notyf adapter for PHPFlasher. Lightweight and modern toast notifications.

## Requirements

- PHP >= 8.2
- PHPFlasher ^2.5.1

## Installation

```bash
composer require php-flasher/flasher-notyf
```

## Quick Start

```php
// Basic usage
notyf('Operation completed successfully!', 'success');
notyf('An error occurred.', 'error');
notyf('Information message.', 'info');
notyf('Warning message.', 'warning');

// With options
notyf('Success message', 'success', [
    'duration' => 4000,
    'position' => [
        'x' => 'right',
        'y' => 'top',
    ],
]);

// Custom notification
notyf('Custom message', 'custom-type');
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
notyf($message, 'success', $options, $title);

// Error notification
notyf($message, 'error', $options, $title);

// Info notification
notyf($message, 'info', $options, $title);

// Warning notification
notyf($message, 'warning', $options, $title);

// Custom notification type
notyf($message, $type, $options, $title);

// With options
notyf($message, 'success', [
    'duration' => 4000,
    'position' => [
        'x' => 'right',
        'y' => 'top',
    ],
], $title);
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
