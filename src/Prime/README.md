# PHPFlasher Core

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher.svg)](https://packagist.org/packages/php-flasher/flasher)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher.svg)](https://packagist.org/packages/php-flasher/flasher)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher.svg)](https://packagist.org/packages/php-flasher/flasher)

Framework-agnostic flash notifications library for PHP. Build custom integrations or use with any PHP project.

## Requirements

- PHP >= 8.2

## Installation

```bash
composer require php-flasher/flasher
```

## Quick Start

```php
// Success notification
flash('Operation completed successfully!', 'success');

// Error notification
flash('An error occurred.', 'error');

// With options
flash('Profile updated!', 'success', [
    'timeout' => 5000,
    'position' => 'top-right',
]);

// With translation
flash('Welcome back!', 'info', [
    'translate' => true,
    'locale' => 'en',
]);
```

## Key Features

- **Framework Agnostic**: Works with Laravel, Symfony, or any PHP project
- **Plugin System**: Extensible architecture for adding custom adapters
- **Stamp Pattern**: Flexible metadata system for notifications
- **Storage Management**: Multiple storage backends (session, array, etc.)
- **Event System**: Event-driven architecture for customization
- **Response Handling**: HTML and JSON response formats

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
