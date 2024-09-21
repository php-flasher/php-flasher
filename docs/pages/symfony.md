---
permalink: /symfony/
title: Symfony
description: Integrate PHPFlasher in your Symfony application to enhance user experience with flash notifications. This open-source package simplifies the addition of engaging messages following user actions.
framework: symfony
---

## <i class="fa-duotone fa-list-radio"></i> Requirements

**<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** helps you easily add flash notifications to your **<i class="fa-brands fa-symfony text-black fa-xl"></i> Symfony** projects, improving user feedback with minimal setup.

To use **<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** with Symfony, you need:

> <i class="fa-brands fa-php fa-2xl text-blue-900 mr-1 mb-1"></i> **PHP** v8.2 or higher
> <i class="fa-brands fa-symfony fa-2xl text-black mr-1 ml-4"></i> **Symfony** v7.0 or higher

---

## <i class="fa-duotone fa-list-radio"></i> Installation

**<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** is modular. You can install only the parts you need.

Run this command to install it:

```shell
composer require php-flasher/flasher-symfony
```

After installing, run this command to set up the required assets:

```shell
php bin/console flasher:install
```

---

{% include _usage.md %}

---

## <i class="fa-duotone fa-list-radio"></i> Configuration

If you want to change the default settings, you can publish the configuration file:

```bash
php bin/console flasher:install --config
```

This will create a file at `config/packages/flasher.yaml` with the following content:

```yaml
# config/packages/flasher.yaml

flasher:
    # Default notification library (e.g., 'flasher', 'toastr', 'noty', etc.)
    default: flasher

    # Path to the main JavaScript file of PHPFlasher
    main_script: '/vendor/flasher/flasher.min.js'

    # Path to the stylesheets for PHPFlasher notifications
    styles:
        - '/vendor/flasher/flasher.min.css'

    # Enable translation of PHPFlasher messages using Symfony's translator service
    translate: true

    # Automatically inject PHPFlasher assets in HTML response
    inject_assets: true

    # Global options
    options:
        # timeout in milliseconds
        timeout: 5000
        position: 'top-right'
        escapeHtml: false

    # Map Symfony session keys to PHPFlasher notification types
    flash_bag:
        success: ['success']
        error: ['error', 'danger']
        warning: ['warning', 'alarm']
        info: ['info', 'notice', 'alert']

    # Criteria to filter displayed notifications (limit, types)
    filter:
        # Limit number of displayed notifications
        limit: 5
```

---

## <i class="fa-duotone fa-list-radio"></i> Presets

You can create a preset for a custom notification that you want to reuse in multiple places. Add a `presets` entry in the configuration file.

> A preset is like a pre-defined message you can use in many places.

For example, create a preset named `entity_saved`:

{% assign id = '#/ symfony preset' %}
{% assign type = 'success' %}
{% assign message = 'Entity saved successfully' %}
{% assign title = 'Entity saved' %}
{% assign options = '{}' %}
{% include example.html %}

```yaml
# config/packages/flasher.yaml

flasher:
    presets:
        entity_saved:
            type: '{{ type }}'
            message: '{{ message }}'
            title: '{{ title }}'
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

This is the same as:

```php
class BookController
{
    public function save()
    {
        flash()->{{ type }}('{{ message }}', '{{ title }}');
```

<p id="preset-variables"><a href="#preset-variables" class="anchor"><i class="fa-duotone fa-link"></i> Variables</a></p>

Presets can also have variables that you can replace using the translation system. For example, you can have a preset that shows a personalized welcome message.

```yaml
# config/packages/flasher.yaml

flasher:
    presets:
        hello_user:
            type: {{ type }}
            message: welcome_back_user
```

In your translation file, define `welcome_back_user` with a message containing the variable `:username`.

```yaml
# translations/flasher.en.yaml

welcome_back_user: Welcome back :username
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

---

## <i class="fa-duotone fa-list-radio"></i> RTL support

**<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** makes it easy to use <i class="fa-duotone fa-signs-post text-indigo-900 mr-1 fa-lg"></i> **right-to-left** languages like `Arabic` or `Hebrew`. It automatically detects the text direction and adjusts accordingly.

Just make sure the translation service is enabled, and **<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** will handle the rest.

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

**<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** lets you translate your notification `messages` and `presets`. It comes with translations for `Arabic`, `English`, `French`, `German`, `Spanish`, `Portuguese`, `Russian`, and `Chinese`. You can also add your own translations.

To override the `English` translations for <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>, create a file at `translations/flasher.en.yaml`.

In this file, define **only** the translation strings you want to change. Any strings you don't override will use <strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>'s default translations.

Here are examples of the default translation keys for `Arabic`, `English`, and `French`:

```yaml
# translations/flasher.ar.yaml

success: 'نجاح'
error: 'خطأ'
warning: 'تحذير'
info: 'معلومة'

The resource was created: 'تم إنشاء :resource'
The resource was updated: 'تم تعديل :resource'
The resource was saved: 'تم حفظ :resource'
The resource was deleted: 'تم حذف :resource'

resource: 'الملف'
```

```yaml
# translations/flasher.en.yaml

success: 'Success'
error: 'Error'
warning: 'Warning'
info: 'Info'

The resource was created: 'The :resource was created'
The resource was updated: 'The :resource was updated'
The resource was saved: 'The :resource was saved'
The resource was deleted: 'The :resource was deleted'

resource: 'resource'
```

```yaml
# translations/flasher.fr.yaml

success: 'Succès'
error: 'Erreur'
warning: 'Avertissement'
info: 'Information'

The resource was created: 'La ressource :resource a été ajoutée'
The resource was updated: 'La ressource :resource a été mise à jour'
The resource was saved: 'La ressource :resource a été enregistrée'
The resource was deleted: 'La ressource :resource a été supprimée'

resource: ''
```

> These translation files help you localize notifications to match user preferences, so your application can communicate effectively in different languages.

{% assign id = '#/ symfony arabic translations' %}
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

// Translate the flash message using the PHPFlasher translation files
flash()->success('The resource was created');

flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```

{% assign id = '#/ symfony french translations' %}
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

// Translate the flash message using the PHPFlasher translation files
flash()->success('The resource was created');

flash()->error('{{ errorMessage }}');
flash()->warning('{{ warningMessage }}');
flash()->info('{{ infoMessage }}');
```
