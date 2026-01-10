# PHPFlasher Laravel Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-laravel.svg)](https://packagist.org/packages/php-flasher/flasher-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-laravel.svg)](https://packagist.org/packages/php-flasher/flasher-laravel)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-laravel.svg)](https://packagist.org/packages/php-flasher/flasher-laravel)

Laravel framework adapter for PHPFlasher. Seamless integration with zero JavaScript setup.

## Requirements

- PHP >= 8.2
- Laravel >= 11.0

## Installation

```bash
composer require php-flasher/flasher-laravel
```

Run the install command:

```bash
php artisan flasher:install
```

## Quick Start

```php
// Success notification
flash()->success('Operation completed successfully!');

// Error notification
flash()->error('An error occurred.');

// With options
flash()->success('Profile updated!', [
    'timeout' => 5000,
    'position' => 'top-right',
]);

// In controller
public function update(Request $request)
{
    // Your logic...

    flash()->success('Changes saved!');

    return redirect()->back();
}
```

## Configuration

Publish configuration file:

```bash
php artisan flasher:install --config
```

This creates `config/flasher.php` where you can customize:
- Default adapter
- Global options
- Flash bag mapping
- Presets

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
