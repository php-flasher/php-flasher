# PHPFlasher Notyf Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-notyf.svg)](https://packagist.org/packages/php-flasher/flasher-notyf)

Minimalist, responsive toast notifications using [Notyf](https://github.com/caroso1222/notyf) for PHPFlasher.

## Features

- Lightweight and minimalist design
- Responsive and mobile-friendly
- Customizable positions
- Dismissible notifications
- Ripple effect animation
- Custom icons support

## Installation

**Laravel:**

```bash
composer require php-flasher/flasher-notyf-laravel
php artisan flasher:install
```

**Symfony:**

```bash
composer require php-flasher/flasher-notyf-symfony
php bin/console flasher:install
```

## Quick Start

```php
// Using the helper function
notyf()->success('Profile updated successfully!');

// With custom position
notyf()->info('New notification', [
    'position' => ['x' => 'center', 'y' => 'top'],
]);

// Error notification
notyf()->error('Unable to save changes.');

// Custom duration
notyf()->warning('Please review your input', [
    'duration' => 8000,
]);

// Dismissible notification
notyf()->success('Click to dismiss', [
    'dismissible' => true,
]);

// With ripple effect
notyf()->info('Loading...', ['ripple' => true]);
```

## Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `duration` | int | `5000` | Auto-dismiss delay in ms (0 = sticky) |
| `dismissible` | bool | `false` | Show close button |
| `ripple` | bool | `true` | Enable ripple animation |
| `position.x` | string | `right` | Horizontal position (`left`, `center`, `right`) |
| `position.y` | string | `top` | Vertical position (`top`, `bottom`) |

### Position Combinations

- `{x: 'right', y: 'top'}` (default)
- `{x: 'left', y: 'top'}`
- `{x: 'center', y: 'top'}`
- `{x: 'right', y: 'bottom'}`
- `{x: 'left', y: 'bottom'}`
- `{x: 'center', y: 'bottom'}`

## Livewire Integration

Notyf notifications work seamlessly with Livewire. You can listen to notification events:

```php
use Livewire\Attributes\On;

#[On('notyf:click')]
public function onNotyfClick(array $payload): void
{
    // Handle notification click
}

#[On('notyf:dismiss')]
public function onNotyfDismiss(array $payload): void
{
    // Handle notification dismiss
}
```

### Available Events

| Event | Description |
|-------|-------------|
| `notyf:click` | Fired when notification is clicked |
| `notyf:dismiss` | Fired when notification is dismissed |

## Global Configuration

**Laravel** (`config/flasher.php`):

```php
'plugins' => [
    'notyf' => [
        'options' => [
            'duration' => 5000,
            'dismissible' => true,
            'ripple' => true,
            'position' => [
                'x' => 'right',
                'y' => 'top',
            ],
        ],
    ],
],
```

**Symfony** (`config/packages/flasher.yaml`):

```yaml
flasher:
    plugins:
        notyf:
            options:
                duration: 5000
                dismissible: true
                ripple: true
                position:
                    x: right
                    y: top
```

## Documentation

For complete documentation, visit [php-flasher.io/library/notyf](https://php-flasher.io/library/notyf).

## License

[MIT](https://opensource.org/licenses/MIT)
