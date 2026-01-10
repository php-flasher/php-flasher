# PHPFlasher Toastr Adapter

[![Latest Stable Version](https://img.shields.io/packagist/v/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)

Toastr adapter for [PHPFlasher](https://php-flasher.io).

## Installation

```bash
composer require php-flasher/flasher-toastr-laravel  # Laravel
composer require php-flasher/flasher-toastr-symfony   # Symfony
```

## Quick Start

```php
// Basic usage
flash('toastr')->success('Operation completed successfully!');

// With options
flash('toastr')->info('New message received', [
    'timeOut' => 5000,
    'positionClass' => 'toast-top-right',
]);
```

## Documentation

For complete documentation, visit [php-flasher.io](https://php-flasher.io).

## License

[MIT](https://opensource.org/licenses/MIT)
