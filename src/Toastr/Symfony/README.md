# PHPFlasher Toastr - Symfony Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-toastr-symfony.svg)](https://packagist.org/packages/php-flasher/flasher-toastr-symfony)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-toastr-symfony.svg)](https://packagist.org/packages/php-flasher/flasher-toastr-symfony)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-toastr-symfony.svg)](https://packagist.org/packages/php-flasher/flasher-toastr-symfony)

Symfony adapter for PHPFlasher Toastr. Seamlessly integrate Toastr notifications into Symfony applications.

## Requirements

- PHP >= 8.2
- Symfony >= 7.0
- php-flasher/flasher-symfony ^2.4.0
- php-flasher/flasher-toastr ^2.4.0

## Installation

```bash
composer require php-flasher/flasher-toastr-symfony
```

## Quick Start

```php
// Global helper
toastr('Your changes have been saved!');

// In controller
public function save(): RedirectResponse
{
    // Your logic...

    toastr('Operation completed successfully!');

    return $this->redirectToRoute('home');
}

// With options
toastr('Success message', [
    'timeOut' => 5000,
    'positionClass' => 'toast-top-right',
]);
```

## Features

- **Symfony Helper**: `toastr()` global function
- **Service Injection**: `ToastrFactory` autowired in constructors
- **Twig Integration**: Auto-injects assets in Twig templates
- **Flash Bag**: Converts Symfony flash messages to Toastr notifications

## Configuration

Publish configuration:

```bash
php bin/console flasher:install --config
```

Add to `config/packages/flasher.yaml`:

```yaml
flasher:
    toastr:
        options:
            timeOut: 5000
            progressBar: true
            positionClass: toast-top-right
```

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
