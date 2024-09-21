---
permalink: /laravel/
title: Laravel
handler: flasher
description: Easily add flash notification messages to your Laravel application with PHPFlasher. Follow our step-by-step guide to install and use the library in your project, and start engaging and informing your users with powerful flash messages.
framework: laravel
---

## <i class="fa-duotone fa-list-radio"></i> Requirements

**<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** helps you easily add flash notifications to your **<i class="fa-brands fa-laravel text-red-900 fa-xl"></i> Laravel** projects, improving user feedback with minimal setup.

To use **<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** with Laravel, you need:

> <i class="fa-brands fa-php fa-2xl text-blue-900 mr-1 mb-1"></i> **PHP** v8.2 or higher
> <i class="fa-brands fa-laravel fa-2xl text-red-900 mr-1 ml-4"></i> **Laravel** v11.0 or higher

---

## <i class="fa-duotone fa-list-radio"></i> Installation

**PHPFlasher** is modular, so you can install only the parts you need.

Run this command to install it:

```shell
composer require php-flasher/flasher-laravel
```

After installing, run this command to set up the required assets:

```shell
php artisan flasher:install
```

---

{% include _usage.md %}

---

## <i class="fa-duotone fa-list-radio"></i> Configuration

If you want to change the default settings, you can publish the configuration file:

```bash
php artisan flasher:install --config
```

This will create a file at `config/flasher.php` with the following content:

```php
<?php // config/flasher.php

return [
    // Default notification library (e.g., 'flasher', 'toastr', 'noty', etc.)
    'default' => 'flasher',

    // Path to the main JavaScript file of PHPFlasher
    'main_script' => '/vendor/flasher/flasher.min.js',

    // Path to the stylesheets for PHPFlasher notifications
    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    // Enable translation of PHPFlasher messages using Laravel's translator service
    'translate' => true,

    // Automatically inject PHPFlasher assets in HTML response
    'inject_assets' => true,

    // Global options
    'options' => [
        'timeout' => 5000, // in milliseconds
        'position' => 'top-right',
        'escapeHtml' => false,
    ],

    // Configuration for the flash bag (converting Laravel flash messages)
    // Map Laravel session keys to PHPFlasher types
    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    // Filter criteria for notifications (e.g., limit number, types)
    'filter' => [
        'limit' => 5, // Limit the number of displayed notifications
    ],
];
```

---

## <i class="fa-duotone fa-list-radio"></i> Presets

You can create a preset for a custom notification that you want to reuse in multiple places by adding a `presets` entry in the configuration file.

> A preset is like a pre-defined message you can use in many places.

For example, create a preset named `entity_saved`:

{% assign id = '#/ laravel preset' %}
{% assign type = 'success' %}
{% assign message = 'Entity saved successfully' %}
{% assign title = 'Entity saved' %}
{% assign options = '{}' %}
{% include example.html %}

```php
<?php // config/flasher.php

return [
    'presets' => [
        'entity_saved' => [
            'type' => '{{ type }}',
            'message' => '{{ message }}',
            'title' => '{{ title }}',
        ],
    ],
];
```

To use the preset, call the `preset()` method and pass the name of the preset:

```php
{{ id }}

class BookController
{
    public function save()
    {
        flash()->preset('entity_saved');
```

This is equivalent to:

```php
class BookController
{
    public function save()
    {
        flash()->{{ type }}('{{ message }}', '{{ title }}');
```

<p id="preset-variables"><a href="#preset-variables" class="anchor"><i class="fa-duotone fa-link"></i> Variables</a></p>

Presets can also have variables that you can replace using the translation system. For example, you can have a preset that shows a personalized welcome message.

```php
<?php // config/flasher.php

return [
    'presets' => [
        'hello_user' => [
            'type' => '{{ type }}',
            'message' => 'welcome_back_user',
        ],
    ],
];
```

In your translation file, define `welcome_back_user` with a message containing the variable `:username`.

```php
<?php // /resources/lang/vendor/flasher/en/messages.php

return [
    'welcome_back_user' => 'Welcome back :username',
];
```

To replace `:username` with the actual username in your controller, pass an array with the values to substitute as the second argument:

```php
class BookController
{
    public function save()
    {
        $username = 'John Doe';

        flash()->preset('hello_user', ['username' => $username]);
```

---

## <i class="fa-duotone fa-list-radio"></i> RTL support

<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> makes it easy to use <i class="fa-duotone fa-signs-post text-indigo-900 mr-1 fa-lg"></i> **right-to-left** languages like `Arabic` or `Hebrew`. It automatically detects the text direction and adjusts accordingly.

Just make sure the translation service is enabled, and <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> will handle the rest.

{% assign id = '#/ phpflasher rtl' %}
{% assign type = 'success' %}
{% assign message = 'تمت العملية بنجاح.' %}
{% assign title = 'تهانينا' %}
{% assign options = '{"rtl": true}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->translate('ar')
    ->{{ type }}('Your request was processed successfully.', 'Congratulations!');
```

---

## <i class="fa-duotone fa-list-radio"></i> Translation

<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> lets you translate your notification `messages` and `presets`. It comes with translations for `Arabic`, `English`, `French`, `German`, `Spanish`, `Portuguese`, `Russian`, and `Chinese`. You can also add your own translations.

To override the `English` translations for <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>, create a file at `/resources/lang/vendor/flasher/en/messages.php`.

In this file, define only the translation strings you want to change. Any strings you don't override will use <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>'s default translations.

Here are examples of the default translation keys for `Arabic`, `English`, and `French`:

```php
<?php // /resources/lang/vendor/flasher/ar/messages.php

return [
        'success' => 'نجاح',
        'error' => 'خطأ',
        'warning' => 'تحذير',
        'info' => 'معلومة',

        'The resource was created' => 'تم إنشاء :resource',
        'The resource was updated' => 'تم تعديل :resource',
        'The resource was saved' => 'تم حفظ :resource',
        'The resource was deleted' => 'تم حذف :resource',

        'resource' => 'الملف',
];
```

```php
<?php // /resources/lang/vendor/flasher/en/messages.php

return [
    'success' => 'Success',
    'error' => 'Error',
    'warning' => 'Warning',
    'info' => 'Info',

    'The resource was created' => 'The :resource was created',
    'The resource was updated' => 'The :resource was updated',
    'The resource was saved' => 'The :resource was saved',
    'The resource was deleted' => 'The :resource was deleted',

    'resource' => 'resource',
];
```

```php
<?php // /resources/lang/vendor/flasher/fr/messages.php

return [
        'success' => 'Succès',
        'error' => 'Erreur',
        'warning' => 'Avertissement',
        'info' => 'Information',

        'The resource was created' => 'La ressource :resource a été ajoutée',
        'The resource was updated' => 'La ressource :resource a été mise à jour',
        'The resource was saved' => 'La ressource :resource a été enregistrée',
        'The resource was deleted' => 'La ressource :resource a été supprimée',

        'resource' => '',
];
```

> These translation files help you localize notifications to match user preferences, so your application can communicate effectively in different languages.

{% assign id = '#/ laravel arabic translations' %}
{% assign successMessage = 'تم إنشاء الملف' %}
{% assign errorMessage = 'حدث خطأ أثناء إرسال طلبك.' %}
{% assign warningMessage = 'يجب إكمال جميع الحقول الإلزامية قبل إرسال النموذج' %}
{% assign infoMessage = 'سيتم تحديث هذه الصفحة في غضون 10 دقائق.' %}

<script type="text/javascript">
    messages['{{ id }}'] = [
        {
            handler: 'flasher',
            type: 'success',
            message: '{{ successMessage }}',
            title: 'نجاح',
            options: {},
        },
        {
            handler: 'flasher',
            type: 'error',
            message: '{{ errorMessage }}',
            title: 'خطأ',
            options: {},
        },
        {
            handler: 'flasher',
            type: 'warning',
            message: '{{ warningMessage }}',
            title: 'تحذير',
            options: {},
        },
        {
            handler: 'flasher',
            type: 'info',
            message: '{{ infoMessage }}',
            title: 'معلومة',
            options: {},
        },
        
    ];
</script>

```php
{{ id }}

use Illuminate\Support\Facades\App;

// Set the locale to be used for the translation
App::setLocale('ar');

// Translate the flash message using the PHPFlasher translation files
flash()->success('The resource was created');

flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

{% assign id = '#/ laravel french translations' %}
{% assign successMessage = "La ressource a été ajoutée" %}
{% assign errorMessage = "Une erreur s’est produite lors de l’envoi de votre demande." %}
{% assign warningMessage = "Vous devez remplir tous les champs obligatoires avant de soumettre le formulaire." %}
{% assign infoMessage = "Cette page sera mise à jour dans 10 minutes."%}

<script type="text/javascript">
    messages['{{ id }}'] = [
        {
            handler: 'flasher',
            type: 'success',
            message: '{{ successMessage }}',
            title: 'Succès',
            options: {},
        },
        {
            handler: 'flasher',
            type: 'error',
            message: '{{ errorMessage }}',
            title: 'Erreur',
            options: {},
        },
        {
            handler: 'flasher',
            type: 'warning',
            message: '{{ warningMessage }}',
            title: 'Avertissement',
            options: {},
        },
        {
            handler: 'flasher',
            type: 'info',
            message: '{{ infoMessage }}',
            title: 'Information',
            options: {},
        },
        
    ];
</script>

```php
{{ id }}

use Illuminate\Support\Facades\App;

// Set the locale to be used for the translation
App::setLocale('fr');

// Translate the flash message using the PHPFlasher translation files
flash()->success('The resource was created');

flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```
