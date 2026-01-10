# PHPFlasher Toastr Adapter (Prime)

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)

Toastr adapter for PHPFlasher. Elegant toast notifications with full TypeScript support.

## Requirements

- PHP >= 8.2
- PHPFlasher ^2.4.0

## Installation

```bash
composer require php-flasher/flasher-toastr
```

## Quick Start

```php
use Flasher\Toastr\Prime\ToastrFactory;

// Basic usage
Toastr::success('Operation completed successfully!');
Toastr::error('An error occurred.');
Toastr::info('Information message.');
Toastr::warning('Warning message.');

// With options
Toastr::success('Success message', [
    'timeOut' => 5000,
    'positionClass' => 'toast-top-right',
    'progressBar' => true,
]);

// Custom notification
Toastr::flash('custom-type', 'Custom message');
```

## Features

- **Simple API**: `success()`, `error()`, `info()`, `warning()`, `flash()`
- **Toastr Options**: `timeOut`, `positionClass`, `progressBar`, `closeButton`, `newestOnTop`
- **Type Safety**: Full PHP type hints and PHPStan support
- **Helper Functions**: Global `toastr()` helper for quick access

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
