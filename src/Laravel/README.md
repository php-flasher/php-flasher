<p align="center">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo-dark.svg">
      <img  width="600" src="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo.svg" alt="PHPFlasher Logo">
    </picture>
</p>

<p align="center">Flexible flash notifications system for Laravel</p>

## Official Documentation

Documentation for PHP Flasher can be found on the [PHP Flasher website](https://php-flasher.io).

## Introduction

PHPFlasher offers a solid integration with the Laravel framework, with supports from Laravel 4.0 to 9.

## Install

You can install the PHPFlasher Laravel package using composer.
This is the base package for all Laravel adapters (toastr, sweetalert, notyf ..etc).

```shell
composer require php-flasher/flasher-laravel
```

Then add the service provider to `config/app.php`.

> in Laravel version 5.5 and beyond this step can be skipped if package auto-discovery is enabled.

```php
'providers' => [
    ...
    Flasher\Laravel\FlasherServiceProvider::class,
    ...
];
```

Optionally include the Facade in `config/app.php`.

```php
'Flasher' => Flasher\Laravel\Facade\Flasher::class,
```

## Usage

The usage of this package is very simple and straightforward. it only required **one** step to use it and does not
require anything to be included in your views: 

Use `flash()` helper function inside your controller to set a toast notification for `info`, `success`, `warning` or `error`

```php
<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Database\Eloquent\Model;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = Post::create($request->only(['title', 'body']));

        if ($post instanceof Model) {
            flash()->addSuccess('Data has been saved successfully!');

            return redirect()->route('posts.index');
        }

        flash()->addError('An error has occurred please try again later.');

        return back();
    }
}
```

If you prefer to use depencny injection, you can use the `FlasherInterface` instead:

```php
<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Flasher\Prime\FlasherInterface;use Illuminate\Database\Eloquent\Model;

class PostController extends Controller
{
    public function store(PostRequest $request, FlasherInterface $flasher)
    {
        $post = Post::create($request->only(['title', 'body']));

        if ($post instanceof Model) {
            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('posts.index');
        }

        $flasher->addError('An error has occurred please try again later.');

        return back();
    }
}
```

Basic api methods: 

- `flash()->addSuccess('Data has been saved successfully!')`
- `flash()->addError('Oops! An error has occurred.')`
- `flash()->addWarning('Are you sure you want to delete this item?')`
- `flash()->addInfo('Welcome to the site!')`

## Contact

PHP Flasher is being actively developed by <a href="https://github.com/yoeunes">yoeunes</a>. You can reach out with questions, bug reports, or feature requests 
on any of the following:

- [Github Issues](https://github.com/php-flasher/flasher/issues) 
- [Github](https://github.com/yoeunes)
- [Twitter](https://twitter.com/yoeunes)
- [Linkedin](https://www.linkedin.com/in/younes-khoubza/)
- [Email me directly](mailto:younes.khoubza@gmail.com)

## License

PHP Flasher is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center"> <b>Made with ❤️ by <a href="https://www.linkedin.com/in/younes-khoubza/">Younes KHOUBZA</a> </b> </p>
