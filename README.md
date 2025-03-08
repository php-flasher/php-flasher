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

<p align="center">
    <a href="https://www.linkedin.com/in/younes--ennaji"><img src="https://img.shields.io/badge/author-@yoeunes-blue.svg" alt="Author Badge"></a>
    <a href="https://github.com/php-flasher/php-flasher"><img src="https://img.shields.io/badge/source-php--flasher/php--flasher-blue.svg" alt="Source Code Badge"></a>
    <a href="https://github.com/php-flasher/php-flasher/releases"><img src="https://img.shields.io/github/tag/php-flasher/flasher.svg" alt="GitHub Release Badge"></a>
    <a href="https://github.com/php-flasher/flasher/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="License Badge"></a>
    <a href="https://packagist.org/packages/php-flasher/flasher"><img src="https://img.shields.io/packagist/dt/php-flasher/flasher.svg" alt="Packagist Downloads Badge"></a>
    <a href="https://github.com/php-flasher/php-flasher"><img src="https://img.shields.io/github/stars/php-flasher/php-flasher.svg" alt="GitHub Stars Badge"></a>
    <a href="https://packagist.org/packages/php-flasher/flasher"><img src="https://img.shields.io/packagist/php-v/php-flasher/flasher.svg" alt="Supported PHP Version Badge"></a>
</p>

# PHPFlasher: Beautiful Notifications Made Simple

## 🚀 See It In Action

```php
// In your controller
public function updateProfile(Request $request)
{
    // Process form submission
    $user = Auth::user();
    $user->update($request->validated());
    
    // Show a beautiful notification to the user
    flash()->success('Your profile has been updated successfully!');
    
    return redirect()->back();
}
```

That's it! PHPFlasher will display an elegant success notification to your user. No JavaScript to write, no frontend setup needed.

## 🔄 Compatibility

| Requirements | Version |
|--------------|---------|
| PHP          | ≥ 8.2   |
| Laravel      | ≥ 11.0  |
| Symfony      | ≥ 7.0   |

## 📑 Table of Contents

- [Introduction](#-introduction)
- [Features](#-key-features)
- [Installation](#-installation)
- [Usage Examples](#-usage-examples)
- [Themes](#-themes)
- [Adapters](#-adapters)
- [Advanced Configuration](#-advanced-configuration)
- [Adapter Documentation Example](#-adapter-documentation-example)
- [Community & Support](#-community--support)
- [Contributors](#-contributors-and-sponsors)
- [License](#-license)

## 🌟 Introduction

PHPFlasher is a powerful, framework-agnostic library that makes it simple to add beautiful flash messages to your web applications. It provides a consistent API for displaying notifications across your PHP applications, whether you're using Laravel, Symfony, or any other PHP framework.

Flash messages are short-lived notifications that appear after a user performs an action, such as submitting a form. PHPFlasher helps you create these notifications with minimal effort while ensuring they look great and behave consistently.

## ✨ Key Features

- **Zero JavaScript Required**: Write only PHP code - frontend functionality is handled automatically
- **Framework Support**: First-class Laravel and Symfony integration
- **Beautiful Themes**: Multiple built-in themes ready to use out of the box
- **Multiple Notification Types**: Success, error, warning, and info notifications
- **Highly Customizable**: Positions, timeouts, animations, and more
- **Third-Party Adapters**: Integration with popular libraries like Toastr, SweetAlert, and more
- **API Response Support**: Works with AJAX and API responses
- **TypeScript Support**: Full TypeScript definitions for frontend customization
- **Lightweight**: Minimal performance impact

## 📦 Installation

### For Laravel Projects

```bash
# Install the Laravel adapter
composer require php-flasher/flasher-laravel

# Set up assets automatically
php artisan flasher:install
```

PHPFlasher automatically injects the necessary JavaScript and CSS assets into your Blade templates. No additional setup required!

### For Symfony Projects

```bash
# Install the Symfony adapter
composer require php-flasher/flasher-symfony

# Set up assets automatically
php bin/console flasher:install
```

PHPFlasher automatically injects the necessary JavaScript and CSS assets into your Twig templates.

## 📚 Usage Examples

### Basic Notifications

```php
// Success notification
flash()->success('Operation completed successfully!');

// Error notification
flash()->error('An error occurred. Please try again.');

// Info notification
flash()->info('Your account will expire in 10 days.');

// Warning notification
flash()->warning('Please backup your data before continuing.');
```

### With Custom Titles

```php
flash()->success('Your changes have been saved!', 'Update Successful');
flash()->error('Unable to connect to the server.', 'Connection Error');
```

### With Custom Options

```php
flash()->success('Profile updated successfully!', [
    'timeout' => 10000,       // Display for 10 seconds
    'position' => 'bottom-right',
    'closeButton' => true,
]);

flash()->error('Failed to submit form.', 'Error', [
    'timeout' => 0,           // No timeout (stay until dismissed)
    'position' => 'center',
]);
```

### In Controllers

```php
// Laravel
public function store(Request $request)
{
    // Process form...
    
    flash()->success('Product created successfully!');
    return redirect()->route('products.index');
}

// Symfony
public function store(Request $request, FlasherInterface $flasher)
{
    // Process form...
    
    $flasher->success('Product created successfully!');
    return $this->redirectToRoute('products.index');
}
```

### Specific Use Cases

```php
// Form validation errors
if ($validator->fails()) {
    flash()->error('Please fix the errors in your form.');
    return redirect()->back()->withErrors($validator);
}

// Multi-step process
flash()->success('Step 1 completed!');
flash()->info('Please complete step 2.');

// With HTML content (must enable HTML option)
flash()->success('Your <strong>account</strong> is ready!', [
    'escapeHtml' => false
]);
```

## 🎨 Themes

PHPFlasher comes with beautiful built-in themes ready to use immediately:

### Default Theme (Flasher)

The default theme provides clean, elegant notifications that work well in any application:

```php
flash()->success('Operation completed!');
```

### Other Built-In Themes

PHPFlasher includes multiple themes to match your application's design:

```php
// Set the theme in your configuration or per notification
flash()->success('Operation completed!', [
    'theme' => 'amazon'    // Amazon-inspired theme
]);

// Other available themes:
// - amber: Warm amber styling
// - aurora: Subtle gradient effects
// - crystal: Clean, transparent design
// - emerald: Green-focused modern look
// - facebook: Facebook notification style
// - google: Google Material Design inspired
// - ios: iOS notification style
// - jade: Soft jade color palette
// - material: Material Design implementation
// - minimal: Extremely clean and simple
// - neon: Bright, attention-grabbing
// - onyx: Dark mode sleek design
// - ruby: Bold ruby red accents
// - sapphire: Blue-focused elegant style
// - slack: Slack-inspired notifications
```

### Theme Configuration

You can configure theme defaults in your configuration file:

```php
// Laravel: config/flasher.php
return [
    'themes' => [
        'flasher' => [
            'options' => [
                'timeout' => 5000,
                'position' => 'top-right',
            ],
        ],
        'amazon' => [
            'options' => [
                'timeout' => 3000,
                'position' => 'bottom-right',
            ],
        ],
    ],
];
```

## 🧩 Adapters

Beyond PHPFlasher's built-in themes, you can use third-party notification libraries:

### Available Adapters

#### Toastr

```bash
composer require php-flasher/flasher-toastr-laravel # For Laravel
composer require php-flasher/flasher-toastr-symfony # For Symfony
```

```php
flash('toastr')->success('Message with Toastr!');
```

#### SweetAlert

```bash
composer require php-flasher/flasher-sweetalert-laravel # For Laravel
composer require php-flasher/flasher-sweetalert-symfony # For Symfony
```

```php
flash('sweetalert')->success('Message with SweetAlert!');
```

#### Noty

```bash
composer require php-flasher/flasher-noty-laravel # For Laravel
composer require php-flasher/flasher-noty-symfony # For Symfony
```

```php
flash('noty')->success('Message with Noty!');
```

#### Notyf

```bash
composer require php-flasher/flasher-notyf-laravel # For Laravel
composer require php-flasher/flasher-notyf-symfony # For Symfony
```

```php
flash('notyf')->success('Message with Notyf!');
```

## ⚙️ Advanced Configuration

### Laravel Configuration

Publish and customize the configuration:

```bash
php artisan vendor:publish --tag=flasher-config
```

This creates `config/flasher.php` where you can configure:

```php
return [
    // Default adapter to use
    'default' => 'flasher',
    
    // Theme configuration
    'themes' => [
        'flasher' => [
            'options' => [
                'timeout' => 5000,
                'position' => 'top-right',
            ],
        ],
    ],
    
    // Auto-convert Laravel session flash messages
    'auto_create_from_session' => true,
    
    // Automatically render notifications
    'auto_render' => true,
    
    // Type mappings for Laravel notifications
    'types_mapping' => [
        'success' => 'success',
        'error' => 'error',
        'warning' => 'warning',
        'info' => 'info',
    ],
];
```

### Symfony Configuration

Create or edit `config/packages/flasher.yaml`:

```yaml
flasher:
    default: flasher
    
    themes:
        flasher:
            options:
                timeout: 5000
                position: top-right
    
    auto_create_from_session: true
    auto_render: true
    
    types_mapping:
        success: success
        error: error
        warning: warning
        info: info
```

### Notification Options

Common options you can customize:

```php
flash()->success('Message', [
    // Display duration in milliseconds (0 = until dismissed)
    'timeout' => 5000,
    
    // Notification position
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left, top-center, bottom-center
    
    // Display a close button
    'closeButton' => true,
    
    // Show progress bar during timeout
    'progressBar' => true,
    
    // Right-to-left text direction
    'rtl' => false,
    
    // Allow HTML content in notifications
    'escapeHtml' => false,
    
    // Custom CSS class
    'class' => 'my-custom-notification',
]);
```

## 📘 Adapter Documentation Example

Here's a detailed example of using the Toastr adapter with PHPFlasher:

### Installation

```bash
composer require php-flasher/flasher-toastr
```

For Laravel:
```bash
composer require php-flasher/flasher-toastr-laravel
```

For Symfony:
```bash
composer require php-flasher/flasher-toastr-symfony
```

### Usage

#### Basic Usage

```php
use Flasher\Toastr\Prime\ToastrFactory;

// Inject the factory
public function __construct(private ToastrFactory $toastr)
{
}

public function index()
{
    $this->toastr->success('Toastr is working!');
    
    // Or using the global helper with the specified adapter
    flash('toastr')->success('Toastr is awesome!');
}
```

#### With Options

```php
flash('toastr')->success('Success message', 'Success Title', [
    'timeOut' => 5000,
    'closeButton' => true,
    'newestOnTop' => true,
    'progressBar' => true,
    'positionClass' => 'toast-top-right',
]);
```

#### Available Methods

```php
// Standard notification types
flash('toastr')->success('Success message');
flash('toastr')->info('Information message');
flash('toastr')->warning('Warning message');
flash('toastr')->error('Error message');

// Custom notification
flash('toastr')->flash('custom-type', 'Custom message');
```

#### Toastr Specific Options

| Option           | Type    | Default         | Description                                |
|------------------|---------|----------------|--------------------------------------------|
| closeButton      | Boolean | false          | Display a close button                     |
| closeClass       | String  | 'toast-close-button' | CSS class for close button           |
| newestOnTop      | Boolean | true           | Add notifications to the top of the stack  |
| progressBar      | Boolean | true           | Display progress bar                       |
| positionClass    | String  | 'toast-top-right' | Position of the notification           |
| preventDuplicates | Boolean | false         | Prevent duplicates                         |
| showDuration     | Number  | 300            | Show animation duration in ms              |
| hideDuration     | Number  | 1000           | Hide animation duration in ms              |
| timeOut          | Number  | 5000           | Auto-close duration (0 = disable)          |
| extendedTimeOut  | Number  | 1000           | Duration after hover                       |
| showEasing       | String  | 'swing'        | Show animation easing                      |
| hideEasing       | String  | 'linear'       | Hide animation easing                      |
| showMethod       | String  | 'fadeIn'       | Show animation method                      |
| hideMethod       | String  | 'fadeOut'      | Hide animation method                      |

### Advanced Configuration

#### Laravel Configuration

Publish the configuration file:
```bash
php artisan vendor:publish --tag=flasher-toastr-config
```

#### Symfony Configuration

Edit your `config/packages/flasher.yaml`:
```yaml
flasher:
    toastr:
        options:
            timeOut: 5000
            progressBar: true
```

## Learn More

For additional information, see the [PHPFlasher documentation](https://php-flasher.io).

## 👥 Community & Support

### Getting Help

- **Documentation**: Visit [https://php-flasher.io](https://php-flasher.io)
- **GitHub Issues**: [Report bugs or request features](https://github.com/php-flasher/php-flasher/issues)
- **Stack Overflow**: Ask questions with the `php-flasher` tag

### Common Use Cases

- Form submission feedback
- AJAX request notifications
- Authentication messages
- Error reporting
- Success confirmations
- System alerts

## 🌟 Contributors and Sponsors

Join our team of contributors and make a lasting impact on our project!

We are always looking for passionate individuals who want to contribute their skills and ideas.
Whether you're a developer, designer, or simply have a great idea, we welcome your participation and collaboration.

Shining stars of our community:

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
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/AhmedGamal"><img src="https://avatars.githubusercontent.com/u/11786167?v=4?s=100" width="100px;" alt="Ahmed Gamal"/><br /><sub><b>Ahmed Gamal</b></sub></a><br /><a href="https://github.com/php-flasher/php-flasher/commits?author=AhmedGamal" title="Code">💻</a> <a href="https://github.com/php-flasher/php-flasher/commits?author=AhmedGamal" title="Documentation">📖</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/BrookeDot"><img src="https://avatars.githubusercontent.com/u/150348?v=4?s=100" width="100px;" alt="Brooke."/><br /><sub><b>Brooke.</b></sub></a><br /><a href="https://github.com/php-flasher/php-flasher/commits?author=BrookeDot" title="Documentation">📖</a></td>
    </tr>
  </tbody>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

## 📬 Contact

PHPFlasher is being actively developed by <a href="https://github.com/yoeunes">yoeunes</a>. 
You can reach out with questions, bug reports, or feature requests on any of the following:

- [Github Issues](https://github.com/php-flasher/php-flasher/issues) 
- [Github](https://github.com/yoeunes)
- [Twitter](https://twitter.com/yoeunes)
- [Linkedin](https://www.linkedin.com/in/younes--ennaji/)
- [Email me directly](mailto:younes.ennaji.pro@gmail.com)

## 📝 License

PHPFlasher is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center"> <b>Made with ❤️ by <a href="https://www.linkedin.com/in/younes--ennaji/">Younes ENNAJI</a> </b> </p>

<p align="center">
   <a href="https://github.com/php-flasher/php-flasher/stargazers">
      ⭐ Star if you found this useful ⭐
   </a>
</p>
