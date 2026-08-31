<div align="center">
    <a href="https://github.com/php-flasher/php-flasher/blob/2.x/docs/palestine.md">
        <img src="https://raw.githubusercontent.com/php-flasher/art/main/palestine-banner-support.svg" width="800px"  alt="Help Palestine"/>
    </a>
</div>

<p align="center">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo-dark.png">
      <img src="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo.png" alt="PHPFlasher Logo">
    </picture>
</p>

<h1 align="center">Elegant Flash Notifications for PHP</h1>

<p align="center">
    <strong>One line of PHP. Beautiful notifications. Zero JavaScript.</strong>
</p>

<p align="center">
    <a href="https://packagist.org/packages/php-flasher/flasher"><img src="https://img.shields.io/packagist/dt/php-flasher/flasher.svg?style=flat-square&label=downloads" alt="Downloads"></a>
    <a href="https://github.com/php-flasher/php-flasher"><img src="https://img.shields.io/github/stars/php-flasher/php-flasher.svg?style=flat-square&label=stars" alt="Stars"></a>
    <a href="https://github.com/php-flasher/php-flasher/releases"><img src="https://img.shields.io/github/v/release/php-flasher/flasher.svg?style=flat-square" alt="Release"></a>
    <a href="https://packagist.org/packages/php-flasher/flasher"><img src="https://img.shields.io/packagist/php-v/php-flasher/flasher.svg?style=flat-square" alt="PHP Version"></a>
    <a href="https://github.com/php-flasher/php-flasher/blob/2.x/LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="License"></a>
</p>

<p align="center">
    <a href="https://php-flasher.io"><strong>Documentation</strong></a> ·
    <a href="https://php-flasher.io/playground"><strong>Live Playground</strong></a> ·
    <a href="https://github.com/php-flasher/php-flasher/issues"><strong>Report Bug</strong></a>
</p>

---

## Quick Start

**Laravel:**
```bash
composer require php-flasher/flasher-laravel && php artisan flasher:install
```

**Symfony:**
```bash
composer require php-flasher/flasher-symfony && php bin/console flasher:install
```

**That's it!** Now use it:

```php
flash()->success('Welcome aboard! Your account is ready.');
```

---

## Why PHPFlasher?

| | PHPFlasher | Others |
|---|:---:|:---:|
| **Zero JavaScript** | Write PHP only, frontend handled automatically | Requires manual JS setup |
| **Auto Asset Injection** | CSS/JS injected automatically | Manual script tags needed |
| **17 Built-in Themes** | Amazon, iOS, Slack, Material & more | Limited or no themes |
| **4 Notification Libraries** | Toastr, SweetAlert, Noty, Notyf | Single library only |
| **Livewire Integration** | Full event system support | Limited or none |
| **RTL Support** | Built-in right-to-left | Often missing |
| **Framework Agnostic** | Laravel, Symfony, or vanilla PHP | Framework-specific |

---

## Notification Types

```php
flash()->success('Operation completed successfully!');
flash()->error('Oops! Something went wrong.');
flash()->warning('Please backup your data before continuing.');
flash()->info('A new version is available for download.');
```

### With Titles

```php
flash()->success('Your changes have been saved.', [], 'Update Complete');
flash()->error('Unable to connect to server.', [], 'Connection Failed');
```

### With Options

```php
flash()->success('Profile updated!', [
    'position' => 'bottom-right',
    'timeout' => 10000,
]);
```

---

## 17 Beautiful Themes

PHPFlasher includes **17 professionally designed themes** ready to use:

```php
flash()->success('Welcome!', ['theme' => 'amazon']);
flash()->success('Welcome!', ['theme' => 'ios']);
flash()->success('Welcome!', ['theme' => 'slack']);
flash()->success('Welcome!', ['theme' => 'material']);
```

<details>
<summary><strong>View All Themes</strong></summary>

| Theme | Style |
|-------|-------|
| `flasher` | Default clean design |
| `amazon` | Amazon-inspired e-commerce |
| `ios` | Apple iOS notifications |
| `slack` | Slack messaging style |
| `material` | Google Material Design |
| `google` | Google notifications |
| `facebook` | Facebook style |
| `minimal` | Ultra-clean minimal |
| `amber` | Warm amber tones |
| `aurora` | Gradient effects |
| `crystal` | Transparent design |
| `emerald` | Modern green palette |
| `jade` | Soft jade colors |
| `neon` | Bright attention-grabbing |
| `onyx` | Dark mode sleek |
| `ruby` | Bold ruby accents |
| `sapphire` | Elegant blue style |

[**See all themes with live demos →**](https://php-flasher.io/themes)

</details>

---

## Notification Libraries

Need more features? Use popular notification libraries:

### Toastr

```bash
composer require php-flasher/flasher-toastr-laravel
```

```php
toastr()->success('Profile saved!', [
    'positionClass' => 'toast-bottom-right',
    'progressBar' => true,
]);
```

### SweetAlert

```bash
composer require php-flasher/flasher-sweetalert-laravel
```

```php
sweetalert()
    ->showDenyButton()
    ->showCancelButton()
    ->warning('Do you want to save changes?');
```

### Noty

```bash
composer require php-flasher/flasher-noty-laravel
```

```php
noty()->success('Data synchronized!', [
    'layout' => 'topCenter',
    'timeout' => 3000,
]);
```

### Notyf

```bash
composer require php-flasher/flasher-notyf-laravel
```

```php
notyf()->success('Upload complete!', [
    'dismissible' => true,
    'ripple' => true,
]);
```

---

## Livewire Integration

PHPFlasher integrates seamlessly with Laravel Livewire:

```php
use Livewire\Attributes\On;

class UserProfile extends Component
{
    public function save()
    {
        // Save logic...

        sweetalert()
            ->showDenyButton()
            ->success('Save changes?');
    }

    #[On('sweetalert:confirmed')]
    public function onConfirmed(array $payload): void
    {
        // User clicked confirm
        $this->user->save();
        flash()->success('Profile saved!');
    }

    #[On('sweetalert:denied')]
    public function onDenied(array $payload): void
    {
        // User clicked deny
    }
}
```

[**Livewire documentation →**](https://php-flasher.io/livewire)

---

## Configuration

### Laravel

```php
// config/flasher.php
return [
    'default' => 'flasher',
    'themes' => [
        'flasher' => [
            'options' => [
                'timeout' => 5000,
                'position' => 'top-right',
            ],
        ],
    ],
];
```

### Symfony

```yaml
# config/packages/flasher.yaml
flasher:
    default: flasher
    themes:
        flasher:
            options:
                timeout: 5000
                position: top-right
```

### Common Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `timeout` | int | `5000` | Auto-dismiss delay in ms (0 = sticky) |
| `position` | string | `top-right` | `top-right`, `top-left`, `bottom-right`, `bottom-left`, `top-center`, `bottom-center` |
| `closeButton` | bool | `true` | Show close button |
| `progressBar` | bool | `true` | Show timeout progress bar |
| `rtl` | bool | `false` | Right-to-left text direction |
| `escapeHtml` | bool | `true` | Escape HTML in messages |

---

## Requirements

| Requirement | Version |
|-------------|---------|
| PHP | >= 8.2 |
| Laravel | >= 11.0 |
| Symfony | >= 7.0 |

---

## Documentation

For complete documentation, visit **[php-flasher.io](https://php-flasher.io)**

- [Installation Guide](https://php-flasher.io/installation)
- [Laravel Integration](https://php-flasher.io/laravel)
- [Symfony Integration](https://php-flasher.io/symfony)
- [Livewire Integration](https://php-flasher.io/livewire)
- [Inertia.js Integration](https://php-flasher.io/inertia)
- [Themes Gallery](https://php-flasher.io/themes)
- [JavaScript Usage](https://php-flasher.io/javascript)

---

## Contributing

Contributions are welcome! Please feel free to submit a [Pull Request](https://github.com/php-flasher/php-flasher/pulls).

## Contributors

<a href="https://github.com/php-flasher/php-flasher/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=php-flasher/php-flasher" alt="Contributors" />
</a>

---

## Support the Project

If PHPFlasher helps you build better applications, please consider:

- **[Star this repository](https://github.com/php-flasher/php-flasher)** to show your support
- **[Report bugs](https://github.com/php-flasher/php-flasher/issues)** to help improve the library
- **[Share on Twitter](https://twitter.com/intent/tweet?text=Check%20out%20PHPFlasher%20-%20beautiful%20flash%20notifications%20for%20PHP!&url=https://github.com/php-flasher/php-flasher)** to spread the word

---

## License

PHPFlasher is open-source software licensed under the [MIT license](LICENSE).

<p align="center">
    <br>
    <strong>Made with ❤️ by <a href="https://github.com/yoeunes">Younes ENNAJI</a></strong>
    <br><br>
    <a href="https://github.com/php-flasher/php-flasher/stargazers">⭐ Star if you find this useful!</a>
</p>
