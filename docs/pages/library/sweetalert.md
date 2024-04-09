---
permalink: /library/sweetalert/
title: Sweetalert
description: Add beautiful, customizable alert messages to your web projects with SweetAlert2, a popular JavaScript library. Easy to install and use, SweetAlert2 is perfect for any project that wants to engage and inform users in a visually appealing way.
handler: sweetalert
data-controller: sweetalert
---

## <i class="fa-duotone fa-list-radio"></i> Installation

**<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> Laravel**:

```shell
composer require php-flasher/flasher-sweetalert-laravel
```

<br />

**<i class="fa-brands fa-symfony text-black fa-xl"></i> Symfony**:

```shell
composer require php-flasher/flasher-sweetalert-symfony
```

--- 

## <i class="fa-duotone fa-list-radio"></i> Usage

{% assign id = '#/ sweetalert' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

namespace App\Controller;

class AppController
{
    public function save()
    {        
        sweetalert()->{{ type }}('{{ message }}');
    }
} 
```

--- 

## <i class="fa-duotone fa-list-radio"></i> Modifiers

For more information on Sweetalert2 alert  options and usage, please refer to the original documentation at [https://sweetalert2.github.io](https://sweetalert2.github.io)

---

> The methods described in the **[Usage](/installation/#-modifiers)** section can also be used with the `sweetalert` adapter.

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
