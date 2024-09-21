---
permalink: /livewire/
title: Livewire
description: Learn how to easily add flash notification messages to your Livewire application with PHPFlasher. Follow our step-by-step guide to install and use the library in your project, and start engaging and informing your users with powerful flash messages.
adapter: flasher
---

**<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** works seamlessly with Livewire v3.

## <i class="fa-duotone fa-list-radio"></i> Requirements

> <i class="fa-brands fa-php fa-2xl text-blue-900 mr-1 mb-1"></i> **PHP** v8.2 or higher
> <i class="fa-brands fa-laravel fa-2xl text-red-900 mr-1 ml-4"></i> **Laravel** v11.0 or higher

---

## <i class="fa-duotone fa-list-radio"></i> Installation

To use **<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** with Livewire, follow the same installation steps as in the [Laravel Installation](/laravel) guide.

```shell
composer require php-flasher/flasher-laravel
```

After installing, run this command to set up the required assets:

```shell
php artisan flasher:install
```

---

## <i class="fa-duotone fa-list-radio"></i> Usage

Dispatch `notifications` from your components

{% assign id = '#/ livewire' %}
{% assign type = 'success' %}
{% assign message = 'User saved successfully!' %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

namespace App\Livewire;

use Livewire\Component;

class UserComponent extends Component
{
    public function save()
    {
        flash()->{{ type }}('{{ message }}');
    }

    public function render()
    {
        return view('livewire.user');
    }
```

---

## <i class="fa-duotone fa-list-radio"></i> Events

For SweetAlert, you can listen to `sweetalert:confirmed`, `sweetalert:denied`, and `sweetalert:dismissed` events within your component.

<script type="text/javascript">
    messages["#/ livewire events"] = {
        handler: "sweetalert",
        type: "info",
        message: "Are you sure you want to delete the user ?",
        options: { 
            showDenyButton: true,
            preConfirm: function() {
                flasher.success('User successfully deleted.');
            },
            preDeny: function() {
                flasher.error('Deletion cancelled.');
            },
        },
    };
</script>

```php
#/ livewire events

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class UserComponent extends Component
{
    public function render()
    {
        return <<<'HTML'
            <div>
                <button wire:click="deleteUser">Delete User</button>
            </div>
        HTML;
    }

    public function deleteUser()
    {
        sweetalert()
            ->showDenyButton()
            ->info('Are you sure you want to delete the user ?');
    }

    #[On('sweetalert:confirmed')]
    public function onConfirmed(array $payload): void
    {
        flash()->info('User successfully deleted.');
    }
    
    #[On('sweetalert:denied')]
    public function onDeny(array $payload): void
    {
        flash()->info('Deletion cancelled.');
    }
}
```

### <i class="fa-duotone fa-list-radio"></i> event handlers context

Each listener method accepts an **array $payload** parameter, which contains:

```php
public function sweetalertConfirmed(array $payload)
{
    $promise = $payload['promise'];
    $envelope = $payload['envelope'];
}
```

- **promise**: The resolved promise from **SweetAlert**.
- **envelope**: The notification where the event happened.
