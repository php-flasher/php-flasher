<div align="center">
    <a href="https://github.com/php-flasher/php-flasher/blob/2.x/docs/palestine.md">
        <img src="https://raw.githubusercontent.com/php-flasher/art/main/palestine-banner-support.svg" width="800px"  alt="Help Palestine"/>
    </a>
</div>

<p align="center">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-github-dark.png">
      <img src="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-github.png" alt="PHPFlasher Logo">
    </picture>
</p>

# PHPFlasher for Laravel

PHPFlasher provides a powerful and intuitive way to add flash notifications to your Laravel applications. With PHPFlasher, you can enhance user feedback efficiently and elegantly.

## Official Documentation

For more comprehensive documentation, please visit [PHPFlasher's Official Documentation](https://php-flasher.io).

## Requirements

- **PHP** v8.2 or higher
- **Laravel** v11.0 or higher

## Installation

To install PHPFlasher for Laravel, use Composer:

```bash
composer require php-flasher/flasher-laravel
```

After installation, publish the assets using:

```bash
php artisan flasher:install
```

## Usage

Quickly integrate flash notifications in your Laravel project using the simple methods provided by PHPFlasher.

- Display a success message.

```php
flash()->success('Operation completed successfully.');
```

- Display an error message.

```php
flash()->error('Oops, something went wrong.');
```

- Display a warning message.

```php
flash()->warning('Your account may have been compromised.');
```

- Display an informational message.

```php
flash()->info('This may take some time. Do not refresh the page.');
```

- Set multiple options at once.

```php
flash()
    ->options(['timeout' => 5000, 'position' => 'top-right'])
    ->success('Your profile has been updated.');
```

- Set a single option.

```php
flash()
    ->option('timer', 5000)
    ->success('Your reservation has been confirmed.');
```

- Set the priority of the message.

```php
flash()
    ->priority(1)
    ->success('Your subscription has been activated.');
```

- Set how many requests a message should persist through.

```php
flash()
    ->hops(2)
    ->info('Your account has been created, but requires verification.');
```

- Translate a message into the specified language.

```php
flash()
    ->translate('ar')
    ->success('Your message has been sent.');
```

## Contributors

<!-- ALL-CONTRIBUTORS-LIST:START -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tbody>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="https://www.linkedin.com/in/younes--ennaji/"><img src="https://avatars.githubusercontent.com/u/10859693?v=4?s=100" width="100px;" alt="Younes ENNAJI"/><br /><sub><b>Younes ENNAJI</b></sub></a><br /><a href="https://github.com/php-flasher/php-flasher/commits?author=yoeunes" title="Code">💻</a> <a href="https://github.com/php-flasher/php-flasher/commits?author=yoeunes" title="Documentation">📖</a> <a href="#maintenance-yoeunes" title="Maintenance">🚧</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/salmayno"><img src="https://avatars.githubusercontent.com/u/27933199?v=4?s=100" width="100px;" alt="Salma Mourad"/><br /><sub><b>Salma Mourad</b></sub></a><br /><a href="#financial-salmayno" title="Financial">💵</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://www.youtube.com/rstacode"><img src="https://avatars.githubusercontent.com/u/35005761?v=4?s=100" width="100px;" alt="Nashwan Abdullah"/><br /><sub><b>Nashwan Abdullah</b></sub></a><br /><a href="#financial-codenashwan" title="Financial">💵</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://darvis.nl/"><img src="https://avatars.githubusercontent.com/u/7394837?v=4?s=100" width="100px;" alt="Arvid de Jong"/><br /><sub><b>Arvid de Jong</b></sub></a><br /><a href="#financial-darviscommerce" title="Financial">💵</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://ashallendesign.co.uk/"><img src="https://avatars.githubusercontent.com/u/39652331?v=4?s=100" width="100px;" alt="Ash Allen"/><br /><sub><b>Ash Allen</b></sub></a><br /><a href="#design-ash-jc-allen" title="Design">🎨</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://about.me/murrant"><img src="https://avatars.githubusercontent.com/u/39462?v=4?s=100" width="100px;" alt="Tony Murray"/><br /><sub><b>Tony Murray</b></sub></a><br /><a href="https://github.com/php-flasher/php-flasher/commits?author=murrant" title="Code">💻</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/n3wborn"><img src="https://avatars.githubusercontent.com/u/10246722?v=4?s=100" width="100px;" alt="Stéphane P"/><br /><sub><b>Stéphane P</b></sub></a><br /><a href="https://github.com/php-flasher/php-flasher/commits?author=n3wborn" title="Documentation">📖</a></td>
    </tr>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="https://www.instagram.com/lucas.maciel_z"><img src="https://avatars.githubusercontent.com/u/80225404?v=4?s=100" width="100px;" alt="Lucas Maciel"/><br /><sub><b>Lucas Maciel</b></sub></a><br /><a href="#design-LucasStorm" title="Design">🎨</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://siek.io/"><img src="https://avatars.githubusercontent.com/u/5730766?v=4?s=100" width="100px;" alt="Antoni Siek"/><br /><sub><b>Antoni Siek</b></sub></a><br /><a href="https://github.com/php-flasher/php-flasher/commits?author=ImJustToNy" title="Code">💻</a></td>
    </tr>
  </tbody>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

## Contact

For support, feature requests, or contributions, reach out via:

- [GitHub Issues](https://github.com/php-flasher/php-flasher/issues)
- [Twitter](https://twitter.com/yoeunes)
- [LinkedIn](https://www.linkedin.com/in/younes--ennaji//)
- [Email](mailto:younes.ennaji.pro@gmail.com)

## License

PHPFlasher is licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center"> <b>Made with ❤️ by <a href="https://www.linkedin.com/in/younes--ennaji//">Younes ENNAJI</a> </b> </p>
