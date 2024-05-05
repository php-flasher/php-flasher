---
permalink: /library/toastr/
title: Toastr
description: Easily add customizable, stylish notification messages to your web projects with Toastr, a popular JavaScript library. With a focus on simplicity and flexibility, Toastr is easy to install and use, making it a great choice for any project that wants to engage and inform users.
handler: toastr
data-controller: toastr
---

## <i class="fa-duotone fa-list-radio"></i> Laravel

<p id="laravel-installation"><a href="#laravel-installation" class="anchor"><i class="fa-duotone fa-link"></i> Installation</a></p>

```shell
composer require php-flasher/flasher-toastr-laravel
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
        'toastr' => [
            'scripts' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/toastr.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => [
                '/vendor/flasher/toastr.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'closeButton' => true
            ],
        ],
    ],
];
```

<br />

## <i class="fa-duotone fa-list-radio"></i> Symfony

<p id="symfony-installation"><a href="#symfony-installation" class="anchor"><i class="fa-duotone fa-link"></i> Installation</a></p>

```shell
composer require php-flasher/flasher-toastr-symfony
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
        noty:
            scripts:
                - '/vendor/flasher/jquery.min.js'
                - '/vendor/flasher/toastr.min.js'
                - '/vendor/flasher/flasher-toastr.min.js'
            styles:
                - '/vendor/flasher/toastr.min.css'
            options:
            # Optional: Add global options here
                closeButton: true
```

---

## <i class="fa-duotone fa-list-radio"></i> Usage

---

> The methods described in the **[Usage](/installation/#-usage)** section can also be used with the `notyf` adapter.

---

To display a notification message, you can either use the `toastr()` helper method or obtain an instance of `toastr` from the service container.
Then, before returning a view or redirecting, call the `success()` method and pass in the desired message to be displayed.

<p id="method-success"><a href="#method-success" class="anchor"><i class="fa-duotone fa-link"></i> success</a></p>

{% assign id = '#/ noty' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

use Flasher\Toastr\Prime\ToastrInterface;

class BookController
{
    public function saveBook()
    {        
        toastr()->success('{{ message }}');
        
        // or simply 
        
        toastr('{{ message }}');
    }
    
    /**
     * if you prefer to use dependency injection 
     */
    public function register(ToastrInterface $toastr)
    {
        // ...

        $toastr->success('{{ site.data.messages["success"] | sample }}');

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

toastr()->{{ type }}('{{ message }}');
```

<p id="method-warning"><a href="#method-warning" class="anchor"><i class="fa-duotone fa-link"></i> warning</a></p>

{% assign id = '#/ usage warning' %}
{% assign type = 'warning' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

toastr()->{{ type }}('{{ message }}');
```

<p id="method-error"><a href="#method-error" class="anchor"><i class="fa-duotone fa-link"></i> error</a></p>

{% assign id = '#/ usage error' %}
{% assign type = 'error' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

toastr()->{{ type }}('{{ message }}');
```

---

For more information on Toastr options and usage, please refer to the original documentation at [https://github.com/CodeSeven/toastr](https://github.com/CodeSeven/toastr)

---

> The methods described in the **[Usage](/installation/#-usage)** section can also be used with the `notyf` adapter.

---

<p id="method-persistent"><a href="#method-persistent" class="anchor"><i class="fa-duotone fa-link"></i> persistent</a></p>

Prevent from Auto Hiding.

```php
toastr()->persistent();
```

{% assign id = '#/ toastr persistent' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeOut": 0, "extendedTimeOut": 0, "closeButton": true}' %}
{% include example.html %}


```php
{{ id }}

toastr()
    ->persistent()
    ->closeButton()
    ->{{ type }}('{{ message }}');
```

---

<p id="method-closeButton"><a href="#method-closeButton" class="anchor"><i class="fa-duotone fa-link"></i> closeButton</a></p>

When set to `true`, a close button is displayed in the toast notification.

```php
toastr()->closeButton(bool $closeButton = true);
```

{% assign id = '#/ toastr closeButton' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"closeButton": true}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->closeButton(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-closeHtml"><a href="#method-closeHtml" class="anchor"><i class="fa-duotone fa-link"></i> closeHtml</a></p>

The HTML content of the close button.

Default ⇒ `<button type="button">&times;</button>`

```php
toastr()->closeHtml(string $closeHtml);
```

{% assign id = '#/ toastr closeHtml' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"closeButton": true, "closeHtml":"<button>⛑</button>"}' %}
{% include example.html %}


```php
{{ id }}

toastr()
    ->closeButton(true)
    ->closeHtml('⛑')
    ->{{ type }}('{{ message }}');
```

---

<p id="method-closeOnHover"><a href="#method-closeOnHover" class="anchor"><i class="fa-duotone fa-link"></i> closeOnHover</a></p>

When set to `true`, the toast will close when the user hovers over it.

Default ⇒ `false`

```php
toastr()->closeOnHover(bool $closeOnHover = true);
```

{% assign id = '#/ toastr closeOnHover' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"closeOnHover": true, "closeDuration": 10}' %}
{% include example.html %}


```php
{{ id }}

toastr()
    ->closeOnHover(true)
    ->closeDuration(10)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-escapeHtml"><a href="#method-escapeHtml" class="anchor"><i class="fa-duotone fa-link"></i> escapeHtml</a></p>

When set to `true`, HTML in the toast message will be escaped.

Default ⇒ `false`

```php
toastr()->escapeHtml(bool $escapeHtml = true);
```

{% assign id = '#/ toastr escapeHtml false' %}
{% assign type = 'error' %}
{% assign message = '<strong>We’re sorry</strong>, but an error occurred.' %}
{% assign options = '{"escapeHtml": false}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->escapeHtml(false)
    ->{{ type }}('{{ message }}');
```

{% assign id = '#/ toastr escapeHtml true' %}
{% assign options = '{"escapeHtml": true}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->escapeHtml(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-newestOnTop"><a href="#method-newestOnTop" class="anchor"><i class="fa-duotone fa-link"></i> newestOnTop</a></p>

When set to `true`, new toast notifications are displayed above older ones.

Default ⇒ `true`

```php
toastr()->newestOnTop(bool $newestOnTop = true);
```

{% assign id = '#/ toastr newestOnTop' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"newestOnTop": true}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->newestOnTop(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-positionClass"><a href="#method-positionClass" class="anchor"><i class="fa-duotone fa-link"></i> positionClass</a></p>

The class applied to the toast container that determines the position of the toast on the screen (e.g. `toast-top-right`, `toast-bottom-left`).

Default ⇒ `toast-top-right`

```php
toastr()->positionClass(string $positionClass);
```

{% assign id = '#/ toastr positionClass' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"positionClass": "toast-top-center"}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->positionClass('toast-top-center')
    ->{{ type }}('{{ message }}');
```

---

<p id="method-preventDuplicates"><a href="#method-preventDuplicates" class="anchor"><i class="fa-duotone fa-link"></i> preventDuplicates</a></p>

When set to `true`, prevents the display of multiple toast notifications with the same message.

Default ⇒ `false`

```php
toastr()->preventDuplicates(bool $preventDuplicates = true);
```

{% assign id = '#/ toastr preventDuplicates' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"preventDuplicates": true}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->preventDuplicates(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-progressBar"><a href="#method-progressBar" class="anchor"><i class="fa-duotone fa-link"></i> progressBar</a></p>

When set to `true`, displays a progress bar in the toast.

Default ⇒ `true`

```php
toastr()->progressBar(bool $progressBar = true);
```

{% assign id = '#/ toastr progressBar' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"progressBar": false}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->progressBar(false)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-rtl"><a href="#method-rtl" class="anchor"><i class="fa-duotone fa-link"></i> rtl</a></p>

When set to `true`, displays the toast notifications in right-to-left mode.

Default ⇒ `false`

```php
toastr()->rtl(bool $rtl = true);
```

{% assign id = '#/ toastr rtl' %}
{% assign type = 'info' %}
{% assign message = 'تم قفل حسابك وتم إرسال رسالة تأكيد إلكترونية.' %}
{% assign options = '{"rtl": true}' %}
{% include example.html %}

```php
{{ id }}

toastr()
    ->rtl(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-tapToDismiss"><a href="#method-tapToDismiss" class="anchor"><i class="fa-duotone fa-link"></i> tapToDismiss</a></p>

When set to `true`, the toast can be dismissed by tapping on it.

```php
toastr()->tapToDismiss(bool $tapToDismiss = true);
```

{% assign id = '#/ toastr tapToDismiss' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"tapToDismiss": true}' %}
{% include example.html %}


```php
{{ id }}

toastr()
    ->tapToDismiss(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-target"><a href="#method-target" class="anchor"><i class="fa-duotone fa-link"></i> target</a></p>

The element that should contain the toast notifications.

Default ⇒ `body`

```php
toastr()->target(string $target);
```

{% assign id = '#/ toastr target' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"target": "body"}' %}
{% include example.html %}


```php
{{ id }}

toastr()
    ->target('body')
    ->{{ type }}('{{ message }}');
```

---

<p id="method-timeOut"><a href="#method-timeOut" class="anchor"><i class="fa-duotone fa-link"></i> timeOut</a></p>

The time in milliseconds to keep the toast visible before it is automatically closed. <br />
Set `timeOut` and `extendedTimeOut` to `0` to make it sticky

Default ⇒ `5000` milliseconds

```php
toastr()->timeOut(int $timeOut, bool $extendedTimeOut = null);
```

{% assign id = '#/ toastr timeOut' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeOut": 1000}' %}
{% include example.html %}


```php
{{ id }}

toastr()
    ->timeOut(1000) // 1 second
    ->{{ type }}('{{ message }}');
```
