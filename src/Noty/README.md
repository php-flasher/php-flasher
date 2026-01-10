# PHPFlasher Noty Adapter

[![Latest Stable Version](https://img.shields.io/packagist/v/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)

Noty adapter for [PHPFlasher](https://php-flasher.io).

## Installation

```bash
composer require php-flasher/flasher-noty-laravel  # Laravel
composer require php-flasher/flasher-noty-symfony   # Symfony
```

## Quick Start

```php
// Basic usage
flash('noty')->success('Operation completed successfully!');

// With options
flash('noty')->warning('Please backup your data.', [
    'timeout' => 3000,
    'layout' => 'topCenter',
]);
```

## Documentation

For complete documentation, visit [php-flasher.io](https://php-flasher.io).

## License

[MIT](https://opensource.org/licenses/MIT)
