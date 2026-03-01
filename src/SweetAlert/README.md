# PHPFlasher SweetAlert Adapter

[![Latest Version](https://img.shields.io/packagist/v/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![Total Downloads](https://img.shields.io/packagist/dt/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)
[![License](https://img.shields.io/packagist/l/php-flasher/flasher-sweetalert.svg)](https://packagist.org/packages/php-flasher/flasher-sweetalert)

Beautiful, responsive, customizable alerts using [SweetAlert2](https://sweetalert2.github.io/) for PHPFlasher.

## Features

- Confirmation dialogs with Confirm/Deny/Cancel buttons
- User input dialogs (text, email, password, select, etc.)
- Custom HTML content support
- Image and icon customization
- Toast mode for non-blocking notifications
- Timer-based auto-close

## Installation

**Laravel:**

```bash
composer require php-flasher/flasher-sweetalert-laravel
php artisan flasher:install
```

**Symfony:**

```bash
composer require php-flasher/flasher-sweetalert-symfony
php bin/console flasher:install
```

## Quick Start

```php
// Using the helper function
sweetalert()->success('Profile updated successfully!');

// With a title
sweetalert()->info('Please read the terms before continuing', 'Important');

// Error notification
sweetalert()->error('Unable to process your request.');

// Toast mode (non-blocking)
sweetalert()->success('Saved!', [
    'toast' => true,
    'position' => 'top-end',
    'timer' => 3000,
]);

// Auto-close with timer
sweetalert()->info('Redirecting...', ['timer' => 2000]);
```

## Confirmation Dialogs

```php
// Simple confirmation
sweetalert()
    ->showDenyButton()
    ->success('Do you want to save the changes?');

// With all three buttons
sweetalert()
    ->showDenyButton(true, 'Don\'t save')
    ->showCancelButton(true, 'Cancel')
    ->warning('Do you want to save the changes?');

// Delete confirmation
sweetalert()
    ->showCancelButton()
    ->confirmButtonColor('#d33')
    ->warning('Are you sure you want to delete this item?', 'This action cannot be undone');
```

## Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `toast` | bool | `false` | Enable toast mode (corner notification) |
| `position` | string | `center` | Dialog position on screen |
| `timer` | int | `null` | Auto-close delay in ms |
| `timerProgressBar` | bool | `false` | Show progress bar for timer |
| `showConfirmButton` | bool | `true` | Show confirm button |
| `showDenyButton` | bool | `false` | Show deny button |
| `showCancelButton` | bool | `false` | Show cancel button |
| `confirmButtonText` | string | `OK` | Confirm button text |
| `denyButtonText` | string | `No` | Deny button text |
| `cancelButtonText` | string | `Cancel` | Cancel button text |

### Position Options

- `top`, `top-start`, `top-end`
- `center`, `center-start`, `center-end`
- `bottom`, `bottom-start`, `bottom-end`

## Livewire Integration

SweetAlert works seamlessly with Livewire. You can listen to button click events:

```php
use Livewire\Attributes\On;

#[On('sweetalert:confirmed')]
public function onConfirmed(array $payload): void
{
    // User clicked confirm button
    $this->performAction();
}

#[On('sweetalert:denied')]
public function onDenied(array $payload): void
{
    // User clicked deny button
}

#[On('sweetalert:dismissed')]
public function onDismissed(array $payload): void
{
    // User dismissed the dialog (clicked cancel or outside)
}
```

### Available Events

| Event | Description |
|-------|-------------|
| `sweetalert:confirmed` | Fired when confirm button is clicked |
| `sweetalert:denied` | Fired when deny button is clicked |
| `sweetalert:dismissed` | Fired when dialog is dismissed |

## Global Configuration

**Laravel** (`config/flasher.php`):

```php
'plugins' => [
    'sweetalert' => [
        'options' => [
            'position' => 'center',
            'timer' => null,
            'showConfirmButton' => true,
            'timerProgressBar' => true,
        ],
    ],
],
```

**Symfony** (`config/packages/flasher.yaml`):

```yaml
flasher:
    plugins:
        sweetalert:
            options:
                position: center
                timer: null
                showConfirmButton: true
                timerProgressBar: true
```

## Documentation

For complete documentation, visit [php-flasher.io/library/sweetalert](https://php-flasher.io/library/sweetalert).

## License

[MIT](https://opensource.org/licenses/MIT)
