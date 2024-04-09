---
permalink: /library/noty/
title: Noty
description: Elevate your user experience with Noty, a popular JavaScript library for creating customizable, stylish notification messages. Easy to install and use, Noty is perfect for any project that wants to engage and inform users in a dynamic way.
handler: noty
data-controller: noty
---

## <i class="fa-duotone fa-list-radio"></i> Installation

**<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> Laravel**:

```shell
composer require php-flasher/flasher-noty-laravel
```

<br />

**<i class="fa-brands fa-symfony text-black fa-xl"></i> Symfony**:

```shell
composer require php-flasher/flasher-noty-symfony
```

---

## <i class="fa-duotone fa-list-radio"></i> Usage

{% assign id = '#/ noty' %}
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
        noty()->{{ type }}('{{ message }}');
    }
}
```

---

## <i class="fa-duotone fa-list-radio"></i> Modifiers

For more information on Noty options and usage, please refer to the original documentation at [https://ned.im/noty/](https://ned.im/noty/)

---

> The methods described in the **[Usage](/installation/#-modifiers)** section can also be used with the `noty` adapter.

---

<p id="method-layout"><a href="#method-layout" class="anchor"><i class="fa-duotone fa-link"></i> layout</a></p>

`top`, `topLeft`, `topCenter`, `topRight`, `center`, `centerLeft`, `centerRight`, `bottom`, `bottomLeft`, `bottomCenter`, `bottomRight` <br />

ClassName generator uses this value → <span class="text-orange-600">noty_layout__${layout}</span>

```php
noty()->layout(string $layout);
```

{% assign id = '#/ noty layout' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"layout":"topCenter"}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->layout('topCenter')
    ->{{ type }}('{{ message }}');
```

---

<p id="method-theme"><a href="#method-theme" class="anchor"><i class="fa-duotone fa-link"></i> theme</a></p>

Possible values: `relax`, `mint`, `metroui`, `light`, `sunset`, `nest`.

ClassName generator uses this value → <span class="text-orange-600">noty_theme__${theme}</span>

```php
noty()->theme(string $theme);
```

> Default Theme: **mint**

<br /> Examples:

{% assign successMessage = site.data.messages['success'] | sample %}
{% assign errorMessage = site.data.messages['error'] | sample %}
{% assign warningMessage = site.data.messages['warning'] | sample %}
{% assign infoMessage = site.data.messages['info'] | sample %}

<script type="text/javascript">
    messages["#/ noty theme mint"] = [
        {
            handler: "{{ page.handler }}",
            type: "success",
            message: "{{ successMessage }}",
            options: { theme: "mint"},
        },
        {
            handler: "{{ page.handler }}",
            type: "error",
            message: "{{ errorMessage }}",
            options: { theme: "mint"},
        },
        {
            handler: "{{ page.handler }}",
            type: "warning",
            message: "{{ warningMessage }}",
            options: { theme: "mint"},
        },
        {
            handler: "{{ page.handler }}",
            type: "info",
            message: "{{ infoMessage }}",
            options: { theme: "mint"},
        }
    ];
</script>

```php
#/ noty theme mint

noty()
    ->theme('mint')
    ->success('{{ successMessage }}');

noty()
    ->theme('mint')
    ->error('{{ errorMessage }}');

noty()
    ->theme('mint')
    ->warning('{{ warningMessage }}');

noty()
    ->theme('mint')
    ->info('{{ infoMessage }}');
```

{% assign successMessage = site.data.messages['success'] | sample %}
{% assign errorMessage = site.data.messages['error'] | sample %}
{% assign warningMessage = site.data.messages['warning'] | sample %}
{% assign infoMessage = site.data.messages['info'] | sample %}

<script type="text/javascript">
    messages["#/ noty theme relax"] = [
        {
            handler: "{{ page.handler }}",
            type: "success",
            message: "{{ successMessage }}",
            options: { theme: "relax"},
        },
        {
            handler: "{{ page.handler }}",
            type: "error",
            message: "{{ errorMessage }}",
            options: { theme: "relax"},
        },
        {
            handler: "{{ page.handler }}",
            type: "warning",
            message: "{{ warningMessage }}",
            options: { theme: "relax"},
        },
        {
            handler: "{{ page.handler }}",
            type: "info",
            message: "{{ infoMessage }}",
            options: { theme: "relax"},
        }
    ];
</script>

```php
#/ noty theme relax

// don't the load the theme css file: https://github.com/needim/noty/blob/master/lib/themes/relax.css

noty()
    ->theme('relax')
    ->success('{{ successMessage }}');

noty()
    ->theme('relax')
    ->error('{{ errorMessage }}');

noty()
    ->theme('relax')
    ->warning('{{ warningMessage }}');

noty()
    ->theme('relax')
    ->info('{{ infoMessage }}');
```

{% assign successMessage = site.data.messages['success'] | sample %}
{% assign errorMessage = site.data.messages['error'] | sample %}
{% assign warningMessage = site.data.messages['warning'] | sample %}
{% assign infoMessage = site.data.messages['info'] | sample %}

<script type="text/javascript">
    messages["#/ noty theme metroui"] = [
        {
            handler: "{{ page.handler }}",
            type: "success",
            message: "{{ successMessage }}",
            options: { theme: "metroui"},
        },
        {
            handler: "{{ page.handler }}",
            type: "error",
            message: "{{ errorMessage }}",
            options: { theme: "metroui"},
        },
        {
            handler: "{{ page.handler }}",
            type: "warning",
            message: "{{ warningMessage }}",
            options: { theme: "metroui"},
        },
        {
            handler: "{{ page.handler }}",
            type: "info",
            message: "{{ infoMessage }}",
            options: { theme: "metroui"},
        }
    ];
</script>

```php
#/ noty theme metroui

// Theme: https://github.com/needim/noty/blob/master/lib/themes/metroui.css

noty()
    ->theme('metroui')
    ->success('{{ successMessage }}');

noty()
    ->theme('metroui')
    ->error('{{ errorMessage }}');

noty()
    ->theme('metroui')
    ->warning('{{ warningMessage }}');

noty()
    ->theme('metroui')
    ->info('{{ infoMessage }}');
```

{% assign successMessage = site.data.messages['success'] | sample %}
{% assign errorMessage = site.data.messages['error'] | sample %}
{% assign warningMessage = site.data.messages['warning'] | sample %}
{% assign infoMessage = site.data.messages['info'] | sample %}

<script type="text/javascript">
    messages["#/ noty theme light"] = [
        {
            handler: "{{ page.handler }}",
            type: "success",
            message: "{{ successMessage }}",
            options: { theme: "light"},
        },
        {
            handler: "{{ page.handler }}",
            type: "error",
            message: "{{ errorMessage }}",
            options: { theme: "light"},
        },
        {
            handler: "{{ page.handler }}",
            type: "warning",
            message: "{{ warningMessage }}",
            options: { theme: "light"},
        },
        {
            handler: "{{ page.handler }}",
            type: "info",
            message: "{{ infoMessage }}",
            options: { theme: "light"},
        }
    ];
</script>

```php
#/ noty theme light

// Theme: https://github.com/needim/noty/blob/master/lib/themes/light.css

noty()
    ->theme('light')
    ->success('{{ successMessage }}');

noty()
    ->theme('light')
    ->error('{{ errorMessage }}');

noty()
    ->theme('light')
    ->warning('{{ warningMessage }}');

noty()
    ->theme('light')
    ->info('{{ infoMessage }}');
```

{% assign successMessage = site.data.messages['success'] | sample %}
{% assign errorMessage = site.data.messages['error'] | sample %}
{% assign warningMessage = site.data.messages['warning'] | sample %}
{% assign infoMessage = site.data.messages['info'] | sample %}

<script type="text/javascript">
    messages["#/ noty theme sunset"] = [
        {
            handler: "{{ page.handler }}",
            type: "success",
            message: "{{ successMessage }}",
            options: { theme: "sunset"},
        },
        {
            handler: "{{ page.handler }}",
            type: "error",
            message: "{{ errorMessage }}",
            options: { theme: "sunset"},
        },
        {
            handler: "{{ page.handler }}",
            type: "warning",
            message: "{{ warningMessage }}",
            options: { theme: "sunset"},
        },
        {
            handler: "{{ page.handler }}",
            type: "info",
            message: "{{ infoMessage }}",
            options: { theme: "sunset"},
        }
    ];
</script>

```php
#/ noty theme sunset
// Theme: https://github.com/needim/noty/blob/master/lib/themes/sunset.css

noty()
    ->theme('sunset')
    ->success('{{ successMessage }}');

noty()
    ->theme('sunset')
    ->error('{{ errorMessage }}');

noty()
    ->theme('sunset')
    ->warning('{{ warningMessage }}');

noty()
    ->theme('sunset')
    ->info('{{ infoMessage }}');
```

---

<p id="method-timeout"><a href="#method-timeout" class="anchor"><i class="fa-duotone fa-link"></i> timeout</a></p>

`false`, `1000`, `3000`, `3500`, etc. Delay for closing event in milliseconds (ms). Set `false` for sticky
notifications.

```php
noty()->timeout(int|bool $timeout)
```

{% assign id = '#/ noty timeout' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeout": 2000}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->timeout(2000) // 2 seconds
    ->{{ type }}('{{ message }}');
```

---

<p id="method-progressBar"><a href="#method-progressBar" class="anchor"><i class="fa-duotone fa-link"></i> progressBar</a></p>

`true`, `false` - Displays a progress bar if timeout is not false.

```php
noty()->progressBar(bool $progressBar = false)
```

{% assign id = '#/ noty progressBar' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"progressBar": false}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->progressBar(false)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-closeWith"><a href="#method-closeWith" class="anchor"><i class="fa-duotone fa-link"></i> closeWith</a></p>

`click`, `button`

Default `click`

```php
noty()->closeWith(string|array $closeWith)
```

{% assign id = '#/ noty closeWith' %}
{% assign type = 'error' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"closeWith": ["click", "button"]}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->closeWith(['click', 'button'])
    ->{{ type }}('{{ message }}');
```

---

<p id="method-animation"><a href="#method-animation" class="anchor"><i class="fa-duotone fa-link"></i> animation</a></p>

If `string`, assumed to be CSS class name. <br />
If `null`, no animation at all. <br />
If `function`, runs the function. (v3.0.1+) <br /><br />
You can use `animate.css` class names or your custom css animations as well.

```php
noty()->animation(string $animation, string $effect)
```

{% assign id = '#/ noty animation' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"animation": null}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->animation(null)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-sounds"><a href="#method-sounds" class="anchor"><i class="fa-duotone fa-link"></i> sounds</a></p>

`sources` : Array of audio sources e.g 'some.wav' <br />
`volume` : nteger value between 0-1 e.g 0.5 <br />
`conditions` : There are two conditions for now: 'docVisible' & 'docHidden'. You can use one of them or both. <br />

```php
noty()->sounds(string $option, mixed $value)
```

{% assign id = '#/ noty sounds' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"sounds": {"sources": ["/static/sounds/notification.wav"], "volume": 0.3, "conditions": ["docVisible", "docHidden"]}}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->sounds('sources', ['/static/sounds/notification.wav'])
    ->sounds('volume', 0.3)
    ->sounds('conditions', ['docVisible', 'docHidden'])
    ->{{ type }}('{{ message }}');
```

---

<p id="method-docTitle"><a href="#method-docTitle" class="anchor"><i class="fa-duotone fa-link"></i> docTitle</a></p>

There are two conditions for now: `docVisible` & `docHidden`. You can use one of them or both.

```php
noty()->docTitle(string $option, mixed $docTitle)
```

{% assign id = '#/ noty docTitle' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"docTitle": {"conditions": ["docVisible", "docHidden"]}}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->docTitle('conditions', ['docVisible', 'docHidden'])
    ->{{ type }}('{{ message }}');
```

---

<p id="method-modal"><a href="#method-modal" class="anchor"><i class="fa-duotone fa-link"></i> modal</a></p>

```php
noty()->modal(bool $modal = true)
```

{% assign id = '#/ noty modal' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"modal": true}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->modal(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-id"><a href="#method-id" class="anchor"><i class="fa-duotone fa-link"></i> id</a></p>

You can use this id with querySelectors. <br />
Generated automatically if false.

```php
noty()->id(bool|string $id)
```

{% assign id = '#/ noty id' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"id": false}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->id(false)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-force"><a href="#method-force" class="anchor"><i class="fa-duotone fa-link"></i> force</a></p>

DOM insert method depends on this parameter. <br />
If `false` uses append, if `true` uses prepend.

```php
noty()->force(bool $force = true)
```

{% assign id = '#/ noty force' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"force": false}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->force(false)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-queue"><a href="#method-queue" class="anchor"><i class="fa-duotone fa-link"></i> queue</a></p>

NEW Named queue system. Details are [here](https://ned.im/noty/#/api).

```php
noty()->queue(string $queue)
```

Default: `global`

{% assign id = '#/ noty queue' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"queue":"global"}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->queue('global')
    ->{{ type }}('{{ message }}');
```

---

<p id="method-killer"><a href="#method-killer" class="anchor"><i class="fa-duotone fa-link"></i> killer</a></p>

If `true` closes all `visible` notifications and shows itself. <br />
If `string(queueName)` closes all `visible` notification on this queue and shows itself.

```php
noty()->killer(bool|string $killer)
```

{% assign id = '#/ noty killer' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"killer": true}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->killer(true)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-container"><a href="#method-container" class="anchor"><i class="fa-duotone fa-link"></i> container</a></p>

Custom container selector string. Like `.my-custom-container`. <br />
Layout parameter will be ignored.

```php
noty()->container(bool|string $container)
```

{% assign id = '#/ noty container' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"container": false}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->container(false)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-visibilityControl"><a href="#method-visibilityControl" class="anchor"><i class="fa-duotone fa-link"></i> visibilityControl</a></p>

If `true` Noty uses PageVisibility API to handle timeout. <br />
To ensure that users do not miss their notifications.

```php
noty()->visibilityControl(bool $visibilityControl)
```

{% assign id = '#/ noty visibilityControl' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"visibilityControl": true}' %}
{% include example.html %}

```php
{{ id }}

noty()
    ->visibilityControl(true)
    ->{{ type }}('{{ message }}');
```
