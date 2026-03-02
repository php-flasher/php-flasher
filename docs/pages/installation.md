---
permalink: /installation/
title: Installation
description: Install PHPFlasher in your project easily. It's modular, so you can install only the parts you need. Just include the library in your composer.json file and run composer install to get started.
---

**<span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span>** is modular and consists of multiple libraries,
allowing users to install and use only the specific components they need for their project.

## <i class="fa-duotone fa-list-radio"></i> Requirements

- **PHP 8.2** or higher
- **Composer**
- **Laravel 11+** or **Symfony 7+**

---

## <i class="fa-duotone fa-list-radio"></i> Installation

**<span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span>** can be installed using composer :

**<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> Laravel**:
```shell
composer require php-flasher/flasher-laravel
```

After installation, you need to run another command to set up the necessary assets for <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>:

```shell
php artisan flasher:install
```

This command publishes the required JavaScript and CSS files to your `public/vendor/flasher` directory. These assets are automatically injected into your HTML responses.

<br />

**<i class="fa-brands fa-symfony text-black fa-xl"></i> Symfony**:
```shell
composer require php-flasher/flasher-symfony
```

After installation, you need to run another command to set up the necessary assets for <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>:

```shell
php bin/console flasher:install
```

This command publishes the required JavaScript and CSS files to your `public/vendor/flasher` directory. These assets are automatically injected into your HTML responses.

---

## <i class="fa-duotone fa-list-radio"></i> Usage

To display a notification message, you can either use the `flash()` helper method or obtain an instance of `flasher` from the service container.
Then, before returning a view or redirecting, call the `success()` method and pass in the desired message to be displayed.

{% assign id = '#/ PHPFlasher' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

use Flasher\Prime\FlasherInterface;

class BookController
{
    public function saveBook()
    {
        // ...

        flash('{{ message }}');
        
        flash()->success('{{ site.data.messages["success"] | sample }}');
            
        app('flasher')->success('{{ site.data.messages["success"] | sample }}');

        // ... redirect or render the view
    }
    
    /**
     * if you prefer to use dependency injection 
     */
    public function register(FlasherInterface $flasher)
    {
        // ...
        
        $flasher->success('{{ site.data.messages["success"] | sample }}');
        
        // ... redirect or render the view
    }
}
```

<br />

It's important to choose a message that is clear and concise, and that accurately reflects the outcome of the operation. <br />
In this case, `"Book has been created successfully!"` is already a good message,
but you may want to tailor it to fit the specific context and language of your application.

> Using this package is actually pretty easy. Adding notifications to your application actually require only one line of code.

{% assign id = '#/ usage success' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

{% assign id = '#/ usage error' %}
{% assign type = 'error' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

{% assign id = '#/ usage warning' %}
{% assign type = 'warning' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

{% assign id = '#/ usage info' %}
{% assign type = 'info' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

---

These four methods (`success`, `error`, `warning`, `info`) are simply convenience shortcuts for the `flash` method,
allowing you to specify the `type` and `message` in a single method call rather than having to pass both as separate arguments to the `flash` method.

```php
flash()->flash(string $type, string $message, string $title = null, array $options = [])
```

{% assign id = '#/ usage flash' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->flash('{{ type }}', '{{ message }}');
```

| param      | description                                                                                                                                                                                                                                                                                                         |
|------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$type`    | Notification type : <span class="text-white bg-green-600 px-2 py-1 rounded">success</span>, <span class="text-white bg-red-600 px-2 py-1 rounded">error</span>, <span class="text-white bg-yellow-600 px-2 py-1 rounded">warning</span>, <span class="text-white bg-blue-600 px-2 py-1 rounded">info</span> etc. |
| `$message` | The body of the message you want to deliver to your user. This may contain HTML. If you add links, be sure to add the appropriate classes for the framework you are using.                                                                                                                                          |
| `$title`   | The notification title, Can also include HTML                                                                                                                                                                                                                                                                       |
| `$options` | Custom options for javascript libraries (toastr, noty, notyf etc.)                                                                                                                                                                                                                                                |                                                                                                                                                                                                                                       |


--- 

<p id="method-options"><a href="#method-options" class="anchor"><i class="fa-duotone fa-link"></i> options</a></p>

You can specify **custom options** for the flash messages when using a JavaScript library like `toastr`, `noty`, or `notyf`. <br /><br />
The `options()` method allows you to set multiple options at once by passing an array of `key-value` pairs,
while the `option()` method allows you to set a single option by specifying its name and value as separate arguments. <br /><br />
The optional `$merge` argument for the `options()` method can be used to specify whether the new options should be merged with any existing options,
or whether they should overwrite them.

```php
flash()->options(array $options, bool $merge = true);
```

> Refer to the documentation for your chosen JavaScript library to see which options are available and how they should be formatted.

{% assign id = '#/ usage options' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeout": 3000, "position": "top-center"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->options([
        'timeout' => 3000, // 3 seconds
        'position' => 'top-center',
    ])
    ->{{ type }}('{{ message }}');
```

| param      | description                                                                          |
|------------|--------------------------------------------------------------------------------------|
| `$options` | Custom options to be passed to the javascript libraries (toastr, noty, notyf etc.) |
| `$merge`   | Merge options if you call the options method multiple times                          |

---

<p id="method-option"><a href="#method-option" class="anchor"><i class="fa-duotone fa-link"></i> option</a></p>

Set a single option by specifying its name and value as separate arguments.

```php
flash()->option(string $option, mixed $value);
```

{% assign id = '#/ usage option' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeout": 3000, "position": "top-center"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->option('position', 'top-center')
    ->option('timeout', 3000)
    ->{{ type }}('{{ message }}');
```

| param     | description  |
|-----------|--------------|
| `$option` | Option key   |
| `$value`  | Option value |

---

<p id="method-priority"><a href="#method-priority" class="anchor"><i class="fa-duotone fa-link"></i> priority</a></p>

Sets the priority of a flash message, the highest priority will be displayed first.

```php
flash()->priority(int $priority);
```

{% assign id = '#/ usage priority' %}
{% assign successMessage = site.data.messages['success'] | sample | prepend: 'Priority 3 → ' %}
{% assign errorMessage = site.data.messages['error'] | sample | prepend: 'Priority 1 → ' %}
{% assign warningMessage = site.data.messages['warning'] | sample | prepend: 'Priority 4 → ' %}
{% assign infoMessage = site.data.messages['info'] | sample | prepend: 'Priority 2 → ' %}

<script type="text/javascript">
    messages["{{ id }}"] = [
        {
            handler: "flasher",
            type: "warning",
            message: "{{ warningMessage }}",
            options: {},
        },
        {
            handler: "flasher",
            type: "success",
            message: "{{ successMessage }}",
            options: {},
        },
        {
            handler: "flasher",
            type: "info",
            message: "{{ infoMessage }}",
            options: {},
        },
        {
            handler: "flasher",
            type: "error",
            message: "{{ errorMessage }}",
            options: {},
        },
    ];
</script>

```php
{{ id }}

flash()
    ->priority(3)
    ->success('{{ successMessage }}');

flash()
    ->priority(1)
    ->error('{{ errorMessage }}');

flash()
    ->priority(4)
    ->warning('{{ warningMessage }}');

flash()
    ->priority(2)
    ->info('{{ infoMessage }}');
```

| param       | description                                                                                |
|-------------|--------------------------------------------------------------------------------------------|
| `$priority` | The priority of the notification, the higher the priority, the sooner it will be displayed |

---

<p id="method-hops"><a href="#method-hops" class="anchor"><i class="fa-duotone fa-link"></i> hops</a></p>

This method sets the number of requests that the flash message should persist for. By default, flash messages are only displayed for a single request and are then discarded. By setting the number of hops, the flash message will be persisted for multiple requests.

As an example, with a multi-page form, you may want to store messages until all pages have been filled.

{% assign id = '#/ usage hops' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
flash()->hops(int $hops);
```

```php
flash()
    ->hops(2)
    ->{{ type }}('{{ message }}');
```

| param   | description                                                   |
|---------|---------------------------------------------------------------|
| `$hops` | indicate how many requests the flash message will persist for |

---

<p id="method-translate"><a href="#method-translate" class="anchor"><i class="fa-duotone fa-link"></i> translate</a></p>

This method sets the `locale` to be used for the translation of the flash message. If a non-null value is provided,
the flash message will be translated into the specified language. If null is provided, the **default** `locale` will be used.

```php
flash()->translate(string $locale = null);
```

{% assign id = '#/ usage translate' %}
{% assign type = 'success' %}
{% assign message = 'تمت العملية بنجاح.' %}
{% assign title = 'تهانينا' %}
{% assign options = '{"rtl": true, "position": "top-right"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->translate('ar')
    ->{{ type }}('Your request was processed successfully.', 'Congratulations!');
```

{% assign id = '#/ usage translate with position' %}
{% assign type = 'success' %}
{% assign message = 'تمت العملية بنجاح.' %}
{% assign title = 'تهانينا' %}
{% assign options = '{"rtl": true, "position": "top-left"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->translate('ar')
    ->option('position', 'top-left')
    ->{{ type }}('Your request was processed successfully.', 'Congratulations!');
```

| param     | description                                                                  |
|-----------|------------------------------------------------------------------------------|
| `$locale` | The locale to be used for the translation, or null to use the default locale |

Note that the `translate()` method only sets the locale; it does not perform the translation itself.

In order to translate the flash message, you will need to provide the appropriate translation keys in your translation files.

In the above example, to translate the flash message into `Arabic`, If you are using **<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> Laravel** you will need to add the following keys to the `resources/lang/ar/messages.php` file:

```php
return [
    'Your request was processed successfully.' => 'تمت العملية بنجاح.',
    'Congratulations!' => 'تهانينا',
];
```

---

<p id="method-created"><a href="#method-created" class="anchor"><i class="fa-duotone fa-link"></i> Resource Operations</a></p>

PHPFlasher provides convenient methods for common CRUD operations. These methods automatically generate appropriate success messages with the resource name.

```php
flash()->created(string|object|null $resource = null): Envelope
flash()->updated(string|object|null $resource = null): Envelope
flash()->saved(string|object|null $resource = null): Envelope
flash()->deleted(string|object|null $resource = null): Envelope
```

{% assign id = '#/ usage created' %}
{% assign type = 'success' %}
{% assign message = 'The resource was created' %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

// Basic usage - displays "The resource was created"
flash()->created();

// With a string - displays "The user was created"
flash()->created('user');

// With an object - automatically resolves the class name
flash()->created($user); // displays "The User was created"
```

{% assign id = '#/ usage updated' %}
{% assign message = 'The post was updated' %}
{% include example.html %}

```php
{{ id }}

flash()->updated('post');
```

{% assign id = '#/ usage deleted' %}
{% assign message = 'The comment was deleted' %}
{% include example.html %}

```php
{{ id }}

flash()->deleted('comment');
```

| param       | description                                                                                |
|-------------|--------------------------------------------------------------------------------------------|
| `$resource` | A string name, an object (class name will be extracted), or null (defaults to "resource") |

> If you pass an object that implements a `getFlashIdentifier()` method, that value will be used as the resource name.

---

<p id="method-when"><a href="#method-when" class="anchor"><i class="fa-duotone fa-link"></i> Conditional Notifications</a></p>

Use `when()` and `unless()` to conditionally display notifications without wrapping your code in if statements.

```php
flash()->when(bool|\Closure $condition): static
flash()->unless(bool|\Closure $condition): static
```

{% assign id = '#/ usage when' %}
{% assign type = 'success' %}
{% assign message = 'Profile updated successfully!' %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

// Only show notification if condition is true
flash()
    ->when($user->isVerified())
    ->success('Profile updated successfully!');

// Using a closure for more complex conditions
flash()
    ->when(fn() => $order->total() > 100)
    ->success('You qualify for free shipping!');
```

{% assign id = '#/ usage unless' %}
{% assign type = 'warning' %}
{% assign message = 'Please verify your email address.' %}
{% include example.html %}

```php
{{ id }}

// Show notification unless condition is true
flash()
    ->unless($user->hasVerifiedEmail())
    ->warning('Please verify your email address.');
```

| param        | description                                                    |
|--------------|----------------------------------------------------------------|
| `$condition` | A boolean or a Closure that returns a boolean                  |

---

<p id="method-keep"><a href="#method-keep" class="anchor"><i class="fa-duotone fa-link"></i> keep</a></p>

The `keep()` method increments the notification's hop count by 1, allowing it to persist through an additional request. This is useful when you need a notification to survive one more redirect.

```php
flash()->keep(): static
```

```php
// Notification will persist through one additional redirect
flash()
    ->keep()
    ->success('This message will survive one more redirect.');
```

| behavior    | description                                                    |
|-------------|----------------------------------------------------------------|
| Default     | Notifications are shown once and then removed                  |
| With keep() | Notification persists through one additional request           |

> The `keep()` method is a shorthand for incrementing the current hops by 1. For more control, use the `hops()` method directly.

---

<p id="method-delay"><a href="#method-delay" class="anchor"><i class="fa-duotone fa-link"></i> delay</a></p>

The `delay()` method sets a delay (in milliseconds) before the notification is displayed. This is useful for staggered notifications or giving users time to focus on content before showing a message.

```php
flash()->delay(int $delay): static
```

{% assign id = '#/ usage delay' %}
{% assign type = 'info' %}
{% assign message = 'Check out our new features!' %}
{% assign options = '{"delay": 2000}' %}
{% include example.html %}

```php
{{ id }}

// Notification appears after 2 seconds
flash()
    ->delay(2000) // 2000 milliseconds = 2 seconds
    ->info('Check out our new features!');
```

| param    | description                                      |
|----------|--------------------------------------------------|
| `$delay` | Delay in milliseconds before showing the notification |

---

<p id="method-preset"><a href="#method-preset" class="anchor"><i class="fa-duotone fa-link"></i> preset</a></p>

Presets allow you to define reusable notification configurations in your config file, then reference them by name in your code.

```php
flash()->preset(string $preset, array $parameters = []): Envelope
```

First, define presets in your configuration file:

**<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> Laravel** - `config/flasher.php`:

```php
return [
    'presets' => [
        'entity_saved' => [
            'type' => 'success',
            'title' => 'Saved',
            'message' => 'The :entity has been saved successfully.',
        ],
        'welcome' => [
            'type' => 'info',
            'message' => 'Welcome back, :name!',
            'options' => [
                'timeout' => 3000,
            ],
        ],
    ],
];
```

**<i class="fa-brands fa-symfony text-black fa-xl"></i> Symfony** - `config/packages/flasher.yaml`:

```yaml
flasher:
    presets:
        entity_saved:
            type: success
            title: Saved
            message: 'The :entity has been saved successfully.'
        welcome:
            type: info
            message: 'Welcome back, :name!'
            options:
                timeout: 3000
```

Then use the preset in your code:

```php
// Use a preset with parameter substitution
flash()->preset('entity_saved', [':entity' => 'product']);

// Another example
flash()->preset('welcome', [':name' => $user->name]);
```

| param         | description                                                |
|---------------|------------------------------------------------------------|
| `$preset`     | The name of the preset as defined in your configuration    |
| `$parameters` | Key-value pairs for placeholder substitution in the message |
