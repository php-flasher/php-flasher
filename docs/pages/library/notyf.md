---
permalink: /library/notyf/
title: Notyf
description: Add lightweight, customizable notification messages to your web projects with Notyf, a popular JavaScript library. With a focus on simplicity and accessibility, Notyf is easy to install and use, making it a great choice for any project that wants to engage and inform users.
handler: notyf
data-controller: notyf
---

## <i class="fa-duotone fa-list-radio"></i> Laravel

<p id="laravel-installation"><a href="#laravel-installation" class="anchor"><i class="fa-duotone fa-link"></i> Installation</a></p>

```shell
composer require php-flasher/flasher-notyf-laravel
```

After installation, you need to run another command to set up the necessary assets for <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>:


```shell
php artisan flasher:install
```

<p id="laravel-configuration"><a href="#laravel-configuration" class="anchor"><i class="fa-duotone fa-link"></i> Configuration</a></p>

```php
<?php // config/flasher.php

return [
    'plugins' => [
        'notyf' => [
            'scripts' => [
                '/vendor/flasher/flasher-notyf.min.js',
            ],
            'styles' => [
                '/vendor/flasher/flasher-notyf.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'dismissible' => true,
            ],
        ],
    ],
];
```

## <i class="fa-duotone fa-list-radio"></i> Symfony

<p id="symfony-installation"><a href="#symfony-installation" class="anchor"><i class="fa-duotone fa-link"></i> Installation</a></p>

```shell
composer require php-flasher/flasher-notyf-symfony
```

After installation, you need to run another command to set up the necessary assets for <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>:

```shell
php bin/console flasher:install
```

<p id="symfony-configuration"><a href="#symfony-configuration" class="anchor"><i class="fa-duotone fa-link"></i> Configuration</a></p>

```yaml
# config/packages/flasher.yaml

flasher:
    plugins:
        notyf:
            scripts:
                - '/vendor/flasher/flasher-notyf.min.js'
            styles:
                - '/vendor/flasher/flasher-notyf.min.css'
            options:
            # Optional: Add global options here
                dismissible: true
```

---

## <i class="fa-duotone fa-list-radio"></i> Usage

---

> The methods described in the **[Usage](/installation/#-usage)** section can also be used with the `notyf` adapter.

---

To display a notification message, you can either use the `notyf()` helper method or obtain an instance of `notyf` from the service container.
Then, before returning a view or redirecting, call the `success()` method and pass in the desired message to be displayed.

<p id="method-success"><a href="#method-success" class="anchor"><i class="fa-duotone fa-link"></i> success</a></p>

{% assign id = '#/ noty' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

use Flasher\Notyf\Prime\NotyfInterface;

class BookController
{
    public function saveBook()
    {        
        notyf()->success('{{ message }}');
        
        // or simply 
        
        notyf('{{ message }}');
    }
    
    /**
     * if you prefer to use dependency injection 
     */
    public function register(NotyfInterface $notyf)
    {
        // ...

        $notyf->success('{{ site.data.messages["success"] | sample }}');

        // ... redirect or render the view
    }
}
```

<p id="method-info"><a href="#method-info" class="anchor"><i class="fa-duotone fa-link"></i> info</a></p>

{% assign id = '#/ usage info' %}
{% assign type = 'info' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

notyf()->{{ type }}('{{ message }}');
```

<p id="method-warning"><a href="#method-warning" class="anchor"><i class="fa-duotone fa-link"></i> warning</a></p>

{% assign id = '#/ usage warning' %}
{% assign type = 'warning' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

notyf()->{{ type }}('{{ message }}');
```

<p id="method-error"><a href="#method-error" class="anchor"><i class="fa-duotone fa-link"></i> error</a></p>

{% assign id = '#/ usage error' %}
{% assign type = 'error' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

notyf()->{{ type }}('{{ message }}');
```

---

For more information on Notyf options and usage, please refer to the original documentation at [https://github.com/caroso1222/notyf](https://github.com/caroso1222/notyf)

---

> The methods described in the **[Usage](/installation/#-usage)** section can also be used with the `notyf` adapter.

---

<p id="method-position"><a href="#method-position" class="anchor"><i class="fa-duotone fa-link"></i> position</a></p>

Viewport location where notifications are rendered

position x ⇒ `left`, `center`, `right` <br />
position y ⇒ `top`, `center`, `bottom`

Default ⇒ x: `right`, y: `bottom`

```php
notyf()->position(string $position, string $value);
```

{% assign id = '#/ notyf position' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"position": {"x": "center", "y":"top"}}' %}
{% include example.html %}

```php
{{ id }}

notyf()
    ->position('x', 'center')
    ->position('y', 'top')
    ->{{ type }}('{{ message }}');
```

---

<p id="method-duration"><a href="#method-duration" class="anchor"><i class="fa-duotone fa-link"></i> duration</a></p>

Number of milliseconds before hiding the notification. Use 0 for infinite duration.

```php
notyf()->duration(int $duration);
```

{% assign id = '#/ notyf duration' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"duration": 2000}' %}
{% include example.html %}

```php
{{ id }}

notyf()
    ->duration(2000) // 2 seconds
    ->{{ type }}('{{ message }}');
```

---

<p id="method-ripple"><a href="#method-ripple" class="anchor"><i class="fa-duotone fa-link"></i> ripple</a></p>

Whether to show the notification with a ripple effect

Default ⇒ `true`

```php
notyf()->ripple(bool $ripple);
```

{% assign id = '#/ notyf ripple true' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"ripple": true}' %}
{% include example.html %}

```php
{{ id }}

notyf()
    ->ripple(true)
    ->{{ type }}('{{ message }}');
```

{% assign id = '#/ notyf ripple false' %}
{% assign options = '{"ripple": false}' %}
{% include example.html %}

```php
{{ id }}

notyf()
    ->ripple(false)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-dismissible"><a href="#method-dismissible" class="anchor"><i class="fa-duotone fa-link"></i> dismissible</a></p>

Whether to allow users to dismiss the notification with a button

Default ⇒ `false`

```php
notyf()->dismissible(bool $dismissible);
```

{% assign id = '#/ notyf dismissible' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"dismissible": true}' %}
{% include example.html %}

```php
{{ id }}

notyf()
    ->dismissible(true)
    ->{{ type }}('{{ message }}');
```
