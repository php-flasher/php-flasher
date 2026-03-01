# PHPFlasher Toastr Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-toastr.svg)](https://packagist.org/packages/php-flasher/flasher-toastr)

Toast notifications using [Toastr](https://github.com/CodeSeven/toastr) for PHPFlasher.

## Features

- Customizable positions (top-right, bottom-left, center, etc.)
- Auto-dismiss with configurable timeout
- Progress bar support
- Close button option
- Queue management (newest on top)
- Prevent duplicate notifications

## Installation

**Laravel:**

```bash
composer require php-flasher/flasher-toastr-laravel
php artisan flasher:install
```

**Symfony:**

```bash
composer require php-flasher/flasher-toastr-symfony
php bin/console flasher:install
```

## Quick Start

```php
// Using the helper function
toastr()->success('Profile updated successfully!');

// With a title
toastr()->info('You have 3 new messages', 'New Messages');

// Error notification
toastr()->error('Unable to save changes. Please try again.');

// Warning with options
toastr()->warning('Session expires in 5 minutes', [
    'timeOut' => 10000,
    'positionClass' => 'toast-bottom-right',
]);

// Sticky notification (won't auto-dismiss)
toastr()->error('Connection lost', ['timeOut' => 0]);

// Prevent duplicate notifications
toastr()->success('Saved!', ['preventDuplicates' => true]);
```

## Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `positionClass` | string | `toast-top-right` | Notification position |
| `timeOut` | int | `5000` | Auto-dismiss delay in ms (0 = sticky) |
| `extendedTimeOut` | int | `1000` | Time after hover before dismiss |
| `progressBar` | bool | `true` | Show countdown progress bar |
| `closeButton` | bool | `true` | Show close button |
| `newestOnTop` | bool | `true` | Stack order for multiple toasts |
| `preventDuplicates` | bool | `false` | Prevent duplicate messages |
| `tapToDismiss` | bool | `true` | Click toast to dismiss |

### Position Options

- `toast-top-right` (default)
- `toast-top-left`
- `toast-top-center`
- `toast-top-full-width`
- `toast-bottom-right`
- `toast-bottom-left`
- `toast-bottom-center`
- `toast-bottom-full-width`

## Livewire Integration

Toastr notifications work seamlessly with Livewire. You can listen to notification events in your components:

```php
use Livewire\Attributes\On;

#[On('toastr:click')]
public function onToastrClick(array $payload): void
{
    // Handle notification click
}

#[On('toastr:close')]
public function onToastrClose(array $payload): void
{
    // Handle notification close
}
```

### Available Events

| Event | Description |
|-------|-------------|
| `toastr:show` | Fired when notification is shown |
| `toastr:click` | Fired when notification is clicked |
| `toastr:close` | Fired when close button is clicked |
| `toastr:hidden` | Fired when notification is hidden |

## Global Configuration

**Laravel** (`config/flasher.php`):

```php
'plugins' => [
    'toastr' => [
        'options' => [
            'positionClass' => 'toast-top-right',
            'timeOut' => 5000,
            'progressBar' => true,
            'closeButton' => true,
        ],
    ],
],
```

**Symfony** (`config/packages/flasher.yaml`):

```yaml
flasher:
    plugins:
        toastr:
            options:
                positionClass: toast-top-right
                timeOut: 5000
                progressBar: true
                closeButton: true
```

## Documentation

For complete documentation, visit [php-flasher.io/library/toastr](https://php-flasher.io/library/toastr).

## License

[MIT](https://opensource.org/licenses/MIT)
