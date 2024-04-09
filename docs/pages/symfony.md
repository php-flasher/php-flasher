---
permalink: /symfony/
title: Symfony
description: Easily add flash notification messages to your Symfony application with PHPFlasher. Follow our step-by-step guide to install and use the library in your project, and start engaging and informing your users with powerful flash messages.
framework: symfony
---

## <i class="fa-duotone fa-list-radio"></i> {% PHPFlasher %} Symfony

{% PHPFlasher %} is a trusted and well-supported package 
that allows you to easily integrate flash notification messages into your <i class="fa-brands fa-symfony text-black fa-xl"></i> **Symfony** projects.

To use {% PHPFlasher %} in a **Symfony** application, you need :

> <i class="fa-brands fa-php fa-2xl text-blue-900 mr-1 mb-1"></i> **PHP** >= 8.2
> <i class="fa-brands fa-symfony fa-2xl text-black mr-1 ml-4"></i> **Symfony** >= 7.0

---

## <i class="fa-duotone fa-list-radio"></i> Installation

{% PHPFlasher %} is modular and consists of multiple libraries, 
allowing users to install and use only the specific components they need for their project.

{% PHPFlasher %} can be installed using composer :

```shell
composer require php-flasher/flasher-symfony
```

---

{% PHPFlasher %} includes a default notification style <i class="fa-duotone fa-comment-captions text-yellow-600"></i>, but users can also install and use additional adapters to customize the appearance of notifications within their projects such as :

* **[Toastr](/library/toastr/)**
* **[Noty](/library/noty/)**
* **[Notyf](/library/notyf/)**
* **[Sweet Alert](/library/sweetalert/)**

---

{% include _usage.md %}

---

## <i class="fa-duotone fa-list-radio"></i> Configuration

As optional, if you want to modify the default configuration, you can publish the configuration file:

```bash
php bin/console flasher:install
```

The configuration file will be located at `config/packages/flasher.yaml` and will have the following content:

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

    # Enable translation of PHPFlasher messages using Symfony's service
    translate: true

    # Automatically inject PHPFlasher assets in HTML response
    inject_assets: true

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

You can create a preset for a custom notification that you want to reuse in multiple places by adding a presets entry in the configuration file.

> You can think of a preset as a pre-defined message that you can use in multiple locations. <br>

For example, you can create a preset named `entity_saved` in the configuration file and then use

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

To use the preset, you can call the `preset()` method and pass the name of the preset as the first argument:

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

Presets can also contain variables that can be substituted by using the translation system. Take the following example where you have a preset showing a personalised welcome message to the user.

```yaml
# config/packages/flasher.yaml

flasher:
    presets:
        hello_user:
            type: {{ type }}
            message: welcome_back_user
```

In the translations file you can define `welcome_back_user` with the message containing the variable `:username`.

```yaml
# translations/flasher.en.yaml

welcome_back_user: Welcome back :username
```

If you want to substitute the `:username` in the above translation with a username in the controller, you can achieve this by passing an array of values to be substituted as the second argument.

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

{% PHPFlasher %} makes it easy to incorporate <i class="fa-duotone fa-signs-post text-indigo-900 mr-1 fa-lg"></i> **right-to-left** languages like `Arabic` or `Hebrew`. 
it automatically detects the text direction and handles the necessary adjustments for you. 

Simply make sure the translation service is enabled and let {% PHPFlasher %} handle the rest.

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

{% PHPFlasher %} allows you to translate your notification `messages`, `presets`, it comes with `Arabic`, `English` and `French` translations out of the box, but you can easily add your own translations.

For example, if you need to override the `English` translation strings for {% PHPFlasher %},  you can create a language file at the following location:
**`translations/flasher.en.yaml`**. 

In this file, you should **only** define the translation strings you want to override. Any translation strings that you don't override will still be loaded from {% PHPFlasher %}'s original language files.

Here is a list of the default translation keys for {% PHPFlasher %}:

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

{% assign id = '#/ symfony arabic translations' %}
{% assign successMessage = 'تم إنشاء الملف' %}
{% assign errorMessage = 'حدث خطأ أثناء إرسال طلبك.' %}
{% assign warningMessage = 'يجب إكمال جميع الحقول الإلزامية قبل إرسال النموذج' %}
{% assign infoMessage = 'سيتم تحديث هذه الصفحة في غضون 10 دقائق.' %}

<script type="text/javascript">
    messages["{{ id }}"] = [
        {
            handler: "flasher",
            type: "success",
            message: "{{ successMessage }}",
            title: "نجاح",
            options: {},
        },
        {
            handler: "flasher",
            type: "error",
            message: "{{ errorMessage }}",
            title: "خطأ",
            options: {},
        },
        {
            handler: "flasher",
            type: "warning",
            message: "{{ warningMessage }}",
            title: "تحذير",
            options: {},
        },
        {
            handler: "flasher",
            type: "info",
            message: "{{ infoMessage }}",
            title: "معلومة",
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
    messages["{{ id }}"] = [
        {
            handler: "flasher",
            type: "success",
            message: "{{ successMessage }}",
            title: "Succès",
            options: {},
        },
        {
            handler: "flasher",
            type: "error",
            message: "{{ errorMessage }}",
            title: "Erreur",
            options: {},
        },
        {
            handler: "flasher",
            type: "warning",
            message: "{{ warningMessage }}",
            title: "Avertissement",
            options: {},
        },
        {
            handler: "flasher",
            type: "info",
            message: "{{ infoMessage }}",
            title: "Information",
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
