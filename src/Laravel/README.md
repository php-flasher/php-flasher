<p align="center">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo-dark.svg">
      <img  width="600" src="https://raw.githubusercontent.com/php-flasher/art/main/php-flasher-logo.svg" alt="PHPFlasher Logo">
    </picture>
</p>

<p align="center">Flexible flash notifications system for Laravel</p>

## Official Documentation

Documentation for PHPFlasher can be found on the [PHPFlasher website](https://php-flasher.io).

## Introduction

PHPFlasher offers a solid integration with the Laravel framework to display flash toast messages, with supports for Laravel 4.0 to 9.

## Install

You can install the PHPFlasher Laravel package using composer.
This is the base package for all Laravel adapters ([__toastr.js__](https://php-flasher.io/docs/adapter/toastr/), [__sweetalert 2__](https://php-flasher.io/docs/adapter/sweetalert/), [__pnotify__](https://php-flasher.io/docs/adapter/pnotify/), [__noty__](https://php-flasher.io/docs/adapter/noty/) and [__notyf__](https://php-flasher.io/docs/adapter/notyf/)).

```shell
composer require php-flasher/flasher-laravel
```

## Usage

The usage of this package is very simple and straight forward. it only required **one** step to use it and does not
require anything to be included in your views:

Use `flash()` helper function anywhere from you application to dispatch you notifications :  `info`, `success`, `warning` or `error`

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

If you prefer to use dependency injection, you can use the `FlasherInterface` instead:

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

- `flash()->addSuccess('Data has been saved successfully!');`
- `flash()->addError('Oops! An error has occurred.');`
- `flash()->addWarning('Are you sure you want to delete this item?');`
- `flash()->addInfo('Welcome to the site!');`

## Laravel service provider if Laravel version < 5.5

> in Laravel version 5.5 and beyond this step can be skipped if package auto-discovery is enabled.

Add the service provider to `config/app.php`.

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

For more details please visit PHPFlasher [Documentation](https://php-flasher.io).

## Contact

PHPFlasher is being actively developed by <a href="https://github.com/yoeunes">yoeunes</a>. You can reach out with questions, bug reports, or feature requests 
on any of the following:

- [Github Issues](https://github.com/php-flasher/flasher/issues) 
- [Github](https://github.com/yoeunes)
- [Twitter](https://twitter.com/yoeunes)
- [Linkedin](https://www.linkedin.com/in/younes-khoubza/)
- [Email me directly](mailto:younes.khoubza@gmail.com)

## License

PHPFlasher is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="center"> <b>Made with ❤️ by <a href="https://www.linkedin.com/in/younes-khoubza/">Younes KHOUBZA</a> </b> </p>
