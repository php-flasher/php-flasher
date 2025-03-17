---
permalink: /symfony/
title: Symfony
description: Integrate PHPFlasher into your Symfony application to enhance user experience with flash notifications. This guide shows you how to add engaging messages after user actions.
framework: symfony
layout: symfony
---

<a id="requirements"></a>
## Requirements

**PHPFlasher** helps you easily add flash notifications to your **Symfony** projects, improving user feedback with minimal setup.

To use **PHPFlasher** with Symfony, you need:

* **PHP** v8.2 or higher
* **Symfony** v7.0 or higher

<a id="installation"></a>
## Installation

**PHPFlasher** is modular. You can install only the parts you need.

Run this command to install it:

```shell
composer require php-flasher/flasher-symfony
```

After installing, run this command to set up the required assets:

```shell
php bin/console flasher:install
```

<a id="usage"></a>
## Usage

### Basic Usage

Here's a basic example of using PHPFlasher in a Symfony controller:

```php
#/ basic usage

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/create', name: 'app_product_create')]
    public function create(): Response
    {
        // Your logic to create a product
        
        // Add a success notification
        flash()->success('Product created successfully!');
        
        return $this->redirectToRoute('app_product_list');
    }
}
```

### Notification Types

PHPFlasher supports different types of notifications:

```php
#/ notification types

// Success message
flash()->success('Your changes have been saved!');

// Error message
flash()->error('Something went wrong!');

// Warning message
flash()->warning('Please review your data before proceeding.');

// Info message
flash()->info('The system will be down for maintenance tonight.');
```

### Adding a Title

You can add a title to your notifications:

```php
flash()->success('Your profile has been updated successfully.', 'Profile Updated');
```

### Notification Options

Customize your notifications with various options:

```php
#/ notification options

flash()->success('Your changes have been saved!')
    ->option('position', 'top-center')  // Position on the screen
    ->option('timeout', 5000)           // How long to display (milliseconds)
    ->option('rtl', true);              // Right-to-left support
```

<a id="configuration"></a>
## Configuration

If you want to change the default settings, you can publish the configuration file:

```bash
php bin/console flasher:install --config
```

This will create a file at `config/packages/flasher.yaml` with the following content:

```yaml
# config/packages/flasher.yaml

flasher:
    # Default notification library (e.g., 'flasher', 'toastr', 'noty', 'notyf', 'sweetalert')
    default: flasher

    # Path to the main PHPFlasher JavaScript file
    main_script: '/vendor/flasher/flasher.min.js'

    # List of CSS files to style your notifications
    styles:
        - '/vendor/flasher/flasher.min.css'

    # Set global options for all notifications (optional)
    # options:
    #     # Time in milliseconds before the notification disappears
    #     timeout: 5000
    #     # Where the notification appears on the screen
    #     position: 'top-right'
  
    # Automatically inject JavaScript and CSS assets into your HTML pages
    inject_assets: true

    # Enable message translation using Symfony's translation service
    translate: true

    # URL patterns to exclude from asset injection and flash_bag conversion
    excluded_paths:
        - '/^\/_profiler/'
        - '/^\/_fragment/'

    # Map Symfony flash message keys to notification types
    flash_bag:
      success: ['success']
      error: ['error', 'danger']
      warning: ['warning', 'alarm']
      info: ['info', 'notice', 'alert']
```

<a id="presets"></a>
## Presets

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

## RTL Support

**PHPFlasher** makes it easy to use **right-to-left** languages like `Arabic` or `Hebrew`. It automatically detects the text direction and adjusts accordingly.

Just make sure the translation service is enabled, and **PHPFlasher** will handle the rest.

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

## Translation

**PHPFlasher** lets you translate your notification `messages` and `presets`. It comes with translations for `Arabic`, `English`, `French`, `German`, `Spanish`, `Portuguese`, `Russian`, and `Chinese`. You can also add your own translations.

To override the `English` translations for **PHPFlasher**, create a file at `translations/flasher.en.yaml`.

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

{% assign id = '#/ symfony translation examples' %}
{% assign type = 'success' %}
{% include example.html %}

```php
{{ id }}

// Translation will automatically use the correct language files
flash()->success('The resource was created');

// You can also specify a different language
flash()->translate('fr')->success('The resource was created');
```
