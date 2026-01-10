# PHPFlasher Symfony Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-symfony.svg)](https://packagist.org/packages/php-flasher/flasher-symfony)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-symfony.svg)](https://packagist.org/packages/php-flasher/flasher-symfony)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-symfony.svg)](https://packagist.org/packages/php-flasher/flasher-symfony)

Symfony framework adapter for PHPFlasher. Seamless integration with zero JavaScript setup.

## Requirements

- PHP >= 8.2
- Symfony >= 7.0

## Installation

```bash
composer require php-flasher/flasher-symfony
```

Run the install command:

```bash
php bin/console flasher:install
```

## Quick Start

```php
// Success notification
flash('Your changes have been saved!');

// In controller
public function save(): Response
{
    // Your logic...

    flash('Operation completed successfully!');

    return $this->redirectToRoute('home');
}

// With dependency injection
public function save(FlasherInterface $flasher): Response
{
    // Your logic...

    $flasher->success('Changes saved!');

    return $this->redirectToRoute('home');
}
```

## Configuration

Publish configuration file:

```bash
php bin/console flasher:install --config
```

This creates `config/packages/flasher.yaml` where you can customize:
- Default adapter
- Global options
- Flash bag mapping
- Presets

## Documentation

Complete documentation: [php-flasher.io](https://php-flasher.io)

## License

[MIT](https://opensource.org/licenses/MIT)
