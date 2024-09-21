## <i class="fa-duotone fa-list-radio"></i> Usage

To show a notification message, you can use the `flash()` helper function or get an instance of `flasher` from the service container. Before you return a view or redirect, call one of the notification methods like `success()` and pass in the message you want to display.

{% assign id = '#/ PHPFlasher' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

use Flasher\Prime\FlasherInterface;

class BookController
{
    public function saveBook()
    {
        // ...

        flash()->success('{{ site.data.messages["success"] | sample }}');

        flash('{{ message }}');

        // ... redirect or render a view
    }
    
    /**
     * if you prefer to use dependency injection 
     */
    public function register(FlasherInterface $flasher)
    {
        // ...

        $flasher->success('{{ site.data.messages["success"] | sample }}');

        // ... redirect or render a view
    }
}
```

<br />

Choose a message that is clear and tells the user what happened. For example, `"Book has been created successfully!"` is a good message, but you can adjust it to fit your application's context and language.

> Using this package is easy. You can add notifications to your application with just one line of code.

{% assign id = '#/ usage success' %}
{% assign type = 'success' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

{% assign id = '#/ usage error' %}
{% assign type = 'error' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

{% assign id = '#/ usage warning' %}
{% assign type = 'warning' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

{% assign id = '#/ usage info' %}
{% assign type = 'info' %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->{{ type }}('{{ message }}');
```

---

These four methods — `success()`, `error()`, `warning()`, and `info()` — are shortcuts for the `flash()` method. They let you specify the `type` and `message` in one method call instead of passing them separately to `flash()`.

```php
flash()->flash(string $type, string $message, string $title = null, array $options = [])
```

{% assign id = '#/ usage flash' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
{{ id }}

flash()->flash('{{ type }}', '{{ message }}');
```


| Parameter  | Description                                                                                                                                                                                                                                                                                                |
|------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$type`    | Notification type: <span class="text-white bg-green-600 px-2 py-1 rounded">success</span>, <span class="text-white bg-red-600 px-2 py-1 rounded">error</span>, <span class="text-white bg-yellow-600 px-2 py-1 rounded">warning</span>, <span class="text-white bg-blue-600 px-2 py-1 rounded">info</span> |
| `$message` | The message you want to show to the user. This can include HTML. If you add links, make sure to add the right classes for your framework.                                                                                                                                                                  |
| `$title`   | The notification title. Can also include HTML.                                                                                                                                                                                                                                                             |
| `$options` | Custom options for JavaScript libraries (toastr, noty, notyf, etc.).                                                                                                                                                                                                                                       |

--- 

<p id="method-options"><a href="#method-options" class="anchor"><i class="fa-duotone fa-link"></i> options</a></p>

The `options()` method lets you set multiple options at once by passing an array of key-value pairs. The `option()` method lets you set a single option by specifying its name and value. The `$append` argument for `options()` decides whether the new options should be added to existing ones (`true`) or replace them (`false`).

```php
flash()->options(array $options, bool $append = true);
```


{% assign id = '#/ usage options' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeout": 3000, "position": "top-center"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->options([
        'timeout' => 3000, // 3 seconds
        'position' => 'top-center',
    ])
    ->{{ type }}('{{ message }}');
```
---

<p id="method-option"><a href="#method-option" class="anchor"><i class="fa-duotone fa-link"></i> option</a></p>

To set a single option:

```php
flash()->option(string $option, mixed $value);
```

{% assign id = '#/ usage option' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{"timeout": 3000, "position": "bottom-right"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->option('position', 'bottom-right')
    ->option('timeout', 3000)
    ->{{ type }}('{{ message }}');
```

---

<p id="method-priority"><a href="#method-priority" class="anchor"><i class="fa-duotone fa-link"></i> priority</a></p>

Set the priority of a flash message. Messages with higher priority appear first.

```php
flash()->priority(int $priority);
```

{% assign id = '#/ usage priority' %}
{% assign successMessage = site.data.messages['success'] | sample | prepend: 'Priority 3 → ' %}
{% assign errorMessage = site.data.messages['error'] | sample | prepend: 'Priority 1 → ' %}
{% assign warningMessage = site.data.messages['warning'] | sample | prepend: 'Priority 4 → ' %}
{% assign infoMessage = site.data.messages['info'] | sample | prepend: 'Priority 2 → ' %}

<script type="text/javascript">
    messages["{{ id }}"] = [
        {
            handler: "flasher",
            type: "warning",
            message: "{{ warningMessage }}",
            options: {},
        },
        {
            handler: "flasher",
            type: "success",
            message: "{{ successMessage }}",
            options: {},
        },
        {
            handler: "flasher",
            type: "info",
            message: "{{ infoMessage }}",
            options: {},
        },
        {
            handler: "flasher",
            type: "error",
            message: "{{ errorMessage }}",
            options: {},
        },
    ];
</script>

```php
{{ id }}

flash()
    ->priority(3)
    ->success('{{ successMessage }}');

flash()
    ->priority(1)
    ->error('{{ errorMessage }}');

flash()
    ->priority(4)
    ->warning('{{ warningMessage }}');

flash()
    ->priority(2)
    ->info('{{ infoMessage }}');
```

| param       | description                                                       |
|-------------|-------------------------------------------------------------------|
| `$priority` | The priority of the notification. Higher numbers are shown first. |

---

<p id="method-hops"><a href="#method-hops" class="anchor"><i class="fa-duotone fa-link"></i> hops</a></p>

The `hops()` method sets how many requests the flash message should last for. By default, flash messages show for one request. Setting the number of hops makes the message stay for multiple requests.

For example, in a multi-page form, you might want to keep messages until all pages are completed.

{% assign id = '#/ usage hops' %}
{% assign type = site.data.messages.types | sample %}
{% assign message = site.data.messages[type] | sample %}
{% assign options = '{}' %}
{% include example.html %}

```php
flash()->hops(int $hops);
```

```php
flash()
    ->hops(2)
    ->{{ type }}('{{ message }}');
```

| param   | description                                           |
|---------|-------------------------------------------------------|
| `$hops` | Number of requests the flash message will persist for |

---

<p id="method-translate"><a href="#method-translate" class="anchor"><i class="fa-duotone fa-link"></i> translate</a></p>

The `translate()` method sets the `locale` for translating the flash message. If you provide a locale, the message will be translated to that language. If you pass `null`, it uses the default locale.

```php
flash()->translate(string $locale = null);
```

{% assign id = '#/ usage translate' %}
{% assign type = 'success' %}
{% assign message = 'تمت العملية بنجاح.' %}
{% assign title = 'تهانينا' %}
{% assign options = '{"rtl": true, "position": "top-right"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->translate('ar')
    ->{{ type }}('Your request was processed successfully.', 'Congratulations!');
```

{% assign id = '#/ usage translate with position' %}
{% assign type = 'success' %}
{% assign message = 'تمت العملية بنجاح.' %}
{% assign title = 'تهانينا' %}
{% assign options = '{"rtl": true, "position": "top-left"}' %}
{% include example.html %}

```php
{{ id }}

flash()
    ->translate('ar')
    ->option('position', 'top-left')
    ->{{ type }}('Your request was processed successfully.', 'Congratulations!');
```

| param     | description                                                  |
|-----------|--------------------------------------------------------------|
| `$locale` | The locale to use for translation, or `null` for the default |

**Note:** The `translate()` method only sets the locale. It doesn't translate the message by itself.

To translate the message, you need to add the translation keys in your translation files.

{% if page.framework == 'laravel' %}

For example, to translate the message into Arabic, add these keys to `resources/lang/ar/messages.php`:

```php
return [
    'Your request was processed successfully.' => 'تمت العملية بنجاح.',
    'Congratulations!' => 'تهانينا',
];
```

{% elsif page.framework == 'symfony' %}

For example, to translate the message into Arabic, add these keys to `translations/messages.ar.yaml`:

```yaml
Your request was processed successfully.: 'تمت العملية بنجاح.'
Congratulations!: 'تهانينا'
```

{% endif %}

