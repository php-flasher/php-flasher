# PHPFlasher SweetAlert Adapter

[![Latest Stable Version](https://img.shields.io/packagist/v/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)

SweetAlert2 adapter for [PHPFlasher](https://php-flasher.io).

## Installation

```bash
composer require php-flasher/flasher-sweetalert-laravel  # Laravel
composer require php-flasher/flasher-sweetalert-symfony   # Symfony
```

## Quick Start

```php
// Basic usage
flash('sweetalert')->success('Operation completed successfully!');

// With options
flash('sweetalert')->info('New message', [
    'timer' => 3000,
    'toast' => true,
]);
```

## Documentation

For complete documentation, visit [php-flasher.io](https://php-flasher.io).

## License

[MIT](https://opensource.org/licenses/MIT)
