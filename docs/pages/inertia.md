---
permalink: /inertia/
title: Inertia
description: Easily add flash notification messages to your Inertia application with PHPFlasher. Follow our step-by-step guide to install and use the library in your project, and start engaging and informing your users with powerful flash messages.
---

<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong> works well with Inertia.js.

## <i class="fa-duotone fa-list-radio"></i> Installation

To use **<strong><span class="text-indigo-900">PHP<span class="text-indigo-500">Flasher</span></span></strong>** with Inertia.js, install it the same way as in the [Laravel Installation](/laravel) guide.

Also, add `@flasher/flasher` to your `package.json`:

```json
"@flasher/flasher": "file:vendor/php-flasher/flasher/Resources"
```

Then, run:

```shell
npm install --force
```

---

## <i class="fa-duotone fa-list-radio"></i> Usage

Send `notifications` from your `HandleInertiaRequests` middleware.

```php
<?php
// app/Http/Middleware/HandleInertiaRequests.php

class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'messages' => flash()->render('array'),
        ]);
    }
}
```

---

Then, display your `notifications` in your `Layout.vue` file:

```html
// resources/js/Shared/Layout.vue
<script>
import flasher from "@flasher/flasher";

export default {
  props: {
    messages: Object,
  },
  watch: {
    messages(value) {
      flasher.render(value);
    }
  }
}
</script>
```

Now, you can trigger notifications from anywhere in your application.

```php
<?php
// app/Http/Controllers/UsersController.php
class UsersController
{
    public function store()
    {
        // your saving logic
        
        flash()->success('User created.');
        
        return Redirect::route('users');
    }
}
```
