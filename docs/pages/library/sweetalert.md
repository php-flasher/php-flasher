---
permalink: /library/sweetalert/
title: Sweetalert
description: Add beautiful, customizable alert messages to your web projects with SweetAlert2, a popular JavaScript library. Easy to install and use, SweetAlert2 is perfect for any project that wants to engage and inform users in a visually appealing way.
handler: sweetalert
data-controller: sweetalert
---

## <i class="fa-duotone fa-list-radio"></i> Laravel

<p id="laravel-installation"><a href="#laravel-installation" class="anchor"><i class="fa-duotone fa-link"></i> Installation</a></p>

```shell
composer require php-flasher/flasher-sweetalert-laravel
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
        'sweetalert' => [
            'scripts' => [
                '/vendor/flasher/sweetalert2.min.js',
                '/vendor/flasher/flasher-sweetalert.min.js',
            ],
            'styles' => [
                '/vendor/flasher/sweetalert2.min.css',
            ],
            'options' => [
                // Optional: Add global options here
                'position' => 'center'
            ],
        ],
    ],
];
```
<br />

## <i class="fa-duotone fa-list-radio"></i> Symfony

<p id="symfony-installation"><a href="#symfony-installation" class="anchor"><i class="fa-duotone fa-link"></i> Installation</a></p>

```shell
composer require php-flasher/flasher-sweetalert-symfony
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
        sweetalert:
            scripts:
                - '/vendor/flasher/sweetalert2.min.js'
                - '/vendor/flasher/flasher-sweetalert.min.js'
            styles:
                - '/vendor/flasher/sweetalert2.min.css'
            options:
            # Optional: Add global options here
                position: center
```

---

## <i class="fa-duotone fa-list-radio"></i> Usage

---

> The methods described in the **[Usage](/installation/#-usage)** section can also be used with the `notyf` adapter.

---

To display a notification message, you can either use the `sweetalert()` helper method or obtain an instance of `sweetalert` from the service container.
Then, before returning a view or redirecting, call the `success()` method and pass in the desired message to be displayed.

<p id="method-success"><a href="#method-success" class="anchor"><i class="fa-duotone fa-link"></i> success</a></p>

{% assign id = '#/ noty' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

use Flasher\SweetAlert\Prime\SweetAlertInterface;

class BookController
{
    public function saveBook()
    {        
        sweetalert()->success('{{ message }}');
        
        // or simply 
        
        sweetalert('{{ message }}');
    }
    
    /**
     * if you prefer to use dependency injection 
     */
    public function register(SweetAlertInterface $sweetalert)
    {
        // ...

        $sweetalert->success('{{ site.data.messages["success"] | sample }}');

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

sweetalert()->{{ type }}('{{ message }}');
```

<p id="method-warning"><a href="#method-warning" class="anchor"><i class="fa-duotone fa-link"></i> warning</a></p>

{% assign id = '#/ usage warning' %}
{% assign type = 'warning' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

sweetalert()->{{ type }}('{{ message }}');
```

<p id="method-error"><a href="#method-error" class="anchor"><i class="fa-duotone fa-link"></i> error</a></p>

{% assign id = '#/ usage error' %}
{% assign type = 'error' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

sweetalert()->{{ type }}('{{ message }}');
```

---

For more information on Sweetalert2 alert  options and usage, please refer to the original documentation at [https://sweetalert2.github.io](https://sweetalert2.github.io)

---

> The methods described in the **[Usage](/installation/#-usage)** section can also be used with the `notyf` adapter.

---

<p id="method-imageUrl"><a href="#method-imageUrl" class="anchor"><i class="fa-duotone fa-link"></i> imageUrl</a></p>

Add a customized icon for the popup. Should contain a string with the path or URL to the image.

```php
sweetalert()->imageUrl(
    string $imageUrl,
    int $imageWidth = null,
    int $imageHeight = null,
    string $imageAlt = null
);
```

---

<p id="method-position"><a href="#method-position" class="anchor"><i class="fa-duotone fa-link"></i> position</a></p>

 Popup window position, can be `top`, `top-start`, `top-end`, `center`, `center-start`, `center-end`, `bottom`, `bottom-start` or `bottom-end`.

```php
sweetalert()->position(string $position);
```

---

<p id="method-toast"><a href="#method-toast" class="anchor"><i class="fa-duotone fa-link"></i> toast</a></p>

Whether or not an alert should be treated as a toast notification. This option is normally coupled with the
position parameter and a timer. Toasts are NEVER autofocused.

```php
sweetalert()->toast(bool $toast = true, string $position = 'top-end', bool $showConfirmButton = false);
```

---

<p id="method-timer"><a href="#method-timer" class="anchor"><i class="fa-duotone fa-link"></i> timer</a></p>

Auto close timer of the popup. Set in ms (milliseconds).

```php
sweetalert()->timer(int $timer);
```

---

<p id="method-timerProgressBar"><a href="#method-timerProgressBar" class="anchor"><i class="fa-duotone fa-link"></i> timerProgressBar</a></p>

If set to `true`, the timer will have a progress bar at the bottom of a popup. Mostly, this feature is useful with toasts.

```php
sweetalert()->timerProgressBar(bool $timerProgressBar = true);
```

---

<p id="method-backdrop"><a href="#method-backdrop" class="anchor"><i class="fa-duotone fa-link"></i> backdrop</a></p>

Whether or not SweetAlert2 should show a full screen click-to-dismiss backdrop. Can be either a boolean or a
string which will be assigned to the CSS background property.

```php
sweetalert()->backdrop(bool $backdrop = true);
```

---

<p id="method-grow"><a href="#method-grow" class="anchor"><i class="fa-duotone fa-link"></i> grow</a></p>

Paired with window position, sets the direction the popup should grow in, can be set to `row`, `column`, `fullscreen` or `false`.

```php
sweetalert()->grow(bool|string $grow);
```

---

<p id="method-showConfirmButton"><a href="#method-showConfirmButton" class="anchor"><i class="fa-duotone fa-link"></i> showConfirmButton</a></p>

If set to `false`, a `Confirm` button will not be shown.

```php
sweetalert()->showConfirmButton(
    bool $showConfirmButton = true, 
    string $confirmButtonText = null, 
    string $confirmButtonColor = null, 
    string $confirmButtonAriaLabel = null
);
```

---

<p id="method-showDenyButton"><a href="#method-showDenyButton" class="anchor"><i class="fa-duotone fa-link"></i> showDenyButton</a></p>

If set to `true`, a `Deny` button will be shown. It can be useful when you want a popup with 3 buttons.

```php
sweetalert()->showDenyButton(
    bool $showDenyButton = true, 
    string $denyButtonText = null, 
    string $denyButtonColor = null, 
    string $denyButtonAriaLabel = null
);
```

---

<p id="method-showCancelButton"><a href="#method-showCancelButton" class="anchor"><i class="fa-duotone fa-link"></i> showCancelButton</a></p>

If set to `true`, a `Cancel` button will be shown, which the user can click on to dismiss the modal.

```php
sweetalert()->showCancelButton(
    bool $showCancelButton = true,
    string $cancelButtonText = null,
    string $cancelButtonColor = null,
    string $cancelButtonAriaLabel = null
);
```

---

<p id="method-confirmButtonText"><a href="#method-confirmButtonText" class="anchor"><i class="fa-duotone fa-link"></i> confirmButtonText</a></p>

Use this to change the text on the `Confirm` button.

```php
sweetalert()->confirmButtonText(
    string $confirmButtonText,
    string $confirmButtonColor = null,
    string $confirmButtonAriaLabel = null
);
```

---

<p id="method-denyButtonText"><a href="#method-denyButtonText" class="anchor"><i class="fa-duotone fa-link"></i> denyButtonText</a></p>

Use this to change the text on the `Deny` button.

```php
sweetalert()->denyButtonText(
    string $denyButtonText,
    string $denyButtonColor = null,
    string $denyButtonAriaLabel = null
);
```

---

<p id="method-cancelButtonText"><a href="#method-cancelButtonText" class="anchor"><i class="fa-duotone fa-link"></i> cancelButtonText</a></p>

Use this to change the text on the `Cancel` button.

```php
sweetalert()->cancelButtonText(
    string $cancelButtonText,
    string $cancelButtonColor = null,
    string $cancelButtonAriaLabel = null
);
```

---

<p id="method-showCloseButton"><a href="#method-showCloseButton" class="anchor"><i class="fa-duotone fa-link"></i> showCloseButton</a></p>

Set to `true` to show close button in top right corner of the popup.

```php
sweetalert()->showCloseButton(bool $showCloseButton = true);
```
