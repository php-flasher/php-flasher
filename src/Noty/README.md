# PHPFlasher Noty Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-noty.svg)](https://packagist.org/packages/php-flasher/flasher-noty)

Dependency-free notification library using [Noty](https://ned.im/noty/) for PHPFlasher.

## Features

- Multiple layout positions (top, bottom, center, corners)
- Queue management for multiple notifications
- Configurable animations
- Action buttons support
- Progress bar for timeout
- Modal mode support

## Installation

**Laravel:**

```bash
composer require php-flasher/flasher-noty-laravel
php artisan flasher:install
```

**Symfony:**

```bash
composer require php-flasher/flasher-noty-symfony
php bin/console flasher:install
```

## Quick Start

```php
// Using the helper function
noty()->success('Profile updated successfully!');

// With custom layout
noty()->info('New message received', [
    'layout' => 'topCenter',
]);

// Error notification
noty()->error('Unable to save changes. Please try again.');

// Warning with custom timeout
noty()->warning('Session expires in 5 minutes', [
    'timeout' => 10000,
]);

// Sticky notification (no auto-dismiss)
noty()->error('Connection lost', ['timeout' => false]);

// With progress bar
noty()->info('Processing...', ['progressBar' => true]);
```

## Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `layout` | string | `topRight` | Notification position |
| `timeout` | int/bool | `5000` | Auto-dismiss delay in ms (`false` = sticky) |
| `progressBar` | bool | `true` | Show countdown progress bar |
| `closeWith` | array | `['click']` | How to close (`click`, `button`) |
| `animation.open` | string | `null` | Opening animation class |
| `animation.close` | string | `null` | Closing animation class |
| `modal` | bool | `false` | Show as modal with overlay |
| `killer` | bool | `false` | Close all other notifications |

### Layout Options

- `top`, `topLeft`, `topCenter`, `topRight`
- `center`, `centerLeft`, `centerRight`
- `bottom`, `bottomLeft`, `bottomCenter`, `bottomRight`

## Livewire Integration

Noty notifications work seamlessly with Livewire. You can listen to notification events:

```php
use Livewire\Attributes\On;

#[On('noty:click')]
public function onNotyClick(array $payload): void
{
    // Handle notification click
}

#[On('noty:close')]
public function onNotyClose(array $payload): void
{
    // Handle notification close
}
```

### Available Events

| Event | Description |
|-------|-------------|
| `noty:show` | Fired when notification is shown |
| `noty:click` | Fired when notification is clicked |
| `noty:close` | Fired when close button is clicked |
| `noty:hidden` | Fired when notification is hidden |

## Global Configuration

**Laravel** (`config/flasher.php`):

```php
'plugins' => [
    'noty' => [
        'options' => [
            'layout' => 'topRight',
            'timeout' => 5000,
            'progressBar' => true,
            'closeWith' => ['click', 'button'],
        ],
    ],
],
```

**Symfony** (`config/packages/flasher.yaml`):

```yaml
flasher:
    plugins:
        noty:
            options:
                layout: topRight
                timeout: 5000
                progressBar: true
                closeWith: ['click', 'button']
```

## Documentation

For complete documentation, visit [php-flasher.io/library/noty](https://php-flasher.io/library/noty).

## License

[MIT](https://opensource.org/licenses/MIT)
