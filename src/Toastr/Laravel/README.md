# PHPFlasher Toastr - Laravel Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-toastr-laravel.svg)](https://packagist.org/packages/php-flasher/flasher-toastr-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-toastr-laravel.svg)](https://packagist.org/packages/php-flasher/flasher-toastr-laravel)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-toastr-laravel.svg)](https://packagist.org/packages/php-flasher/flasher-toastr-laravel)

Laravel adapter for PHPFlasher Toastr. Seamlessly integrate Toastr notifications into Laravel applications.

## Requirements

- PHP >= 8.2
- Laravel >= 11.0
- php-flasher/flasher-laravel ^2.4.0
- php-flasher/flasher-toastr ^2.4.0

## Installation

```bash
composer require php-flasher/flasher-toastr-laravel
```

## Quick Start

```php
// Global helper
toastr()->success('Operation completed successfully!');
toastr()->error('An error occurred.');
toastr()->info('Information message.');
toastr()->warning('Warning message.');

// In controller
public function save(Request $request)
{
    // Your logic...

    toastr()->success('Changes saved!');

    return redirect()->back();
}

// With options
toastr()->success('Success message', [
    'timeOut' => 5000,
    'positionClass' => 'toast-top-right',
]);
```

## Features

- **Laravel Facade**: `toastr()` global helper
- **Dependency Injection**: `ToastrFactory` type-hinted injection
- **Laravel Integration**: Auto-injects assets in Blade templates
- **Flash Bag**: Converts Laravel flash messages to Toastr notifications

## Configuration

Publish configuration:

```bash
php artisan flasher:install --config
```

Add to `config/flasher.php`:

```php
return [
    'plugins' => [
        'toastr' => [
            'options' => [
                'timeOut' => 5000,
                'progressBar' => true,
                'positionClass' => 'toast-top-right',
            ],
        ],
    ],
];
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
