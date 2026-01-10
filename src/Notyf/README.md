# PHPFlasher Notyf Adapter

[![Latest Stable Version](https://img.shields.io/packagist/v/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)

Notyf adapter for [PHPFlasher](https://php-flasher.io).

## Installation

```bash
composer require php-flasher/flasher-notyf-laravel  # Laravel
composer require php-flasher/flasher-notyf-symfony   # Symfony
```

## Quick Start

```php
// Basic usage
flash('notyf')->success('Operation completed successfully!');

// With options
flash('notyf')->info('New message received', [
    'duration' => 4000,
    'position' => 'top-right',
]);
```

## Documentation

For complete documentation, visit [php-flasher.io](https://php-flasher.io).

## License

[MIT](https://opensource.org/licenses/MIT)
